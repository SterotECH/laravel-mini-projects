<?php

namespace App\Http\Controllers;

use App\Http\Requests\TermsAcceptRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class TermsController extends Controller
{
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('terms');
    }

    public function store(TermsAcceptRequest $request): RedirectResponse
    {
        auth()->user()->update([
            'terms_accepted' => true
        ]);

        return redirect()->route('home');
    }
}
