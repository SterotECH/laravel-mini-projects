<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateClientRequest;
use App\Http\Requests\EditClientRequest;
use App\Models\Client;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class ClientController extends Controller
{
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $clients = Client::paginate(20);

        return view('clients.index', compact('clients'));
    }

    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('clients.create');
    }

    public function store(CreateClientRequest $request): RedirectResponse
    {
        Client::create($request->validated());

        return redirect()->route('clients.index');
    }

    public function show(Client $client)
    {
        //
    }

    public function edit(Client $client): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('clients.edit', compact('client'));
    }

    public function update(EditClientRequest $request, Client $client): RedirectResponse
    {
        $client->update($request->validated());

        return redirect()->route('clients.index');
    }

    public function destroy(Client $client): RedirectResponse
    {
        abort_if(Gate::denies('delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            $client->delete();
        } catch (QueryException $e) {
            if($e->getCode() === '23000') {
                return redirect()->back()->with('status', 'Client belongs to project and/or task. Cannot delete.');
            }
        }

        return redirect()->route('clients.index');
    }
}
