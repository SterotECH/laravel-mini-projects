<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use App\Notifications\ProjectAssigned;
use App\Http\Requests\EditProjectRequest;
use App\Http\Requests\CreateProjectRequest;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with(['user', 'client'])->filterStatus(request('status'))->paginate(20);

        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        $users = User::all()->pluck('full_name', 'id');
        $clients = Client::all()->pluck('company_name', 'id');

        return view('projects.create', compact('users', 'clients'));
    }

    public function store(CreateProjectRequest $request)
    {
        $project = Project::create($request->validated());

        $user = User::find($request->user_id);

        $user->notify(new ProjectAssigned($project));

        return redirect()->route('projects.index');
    }

    public function show(Project $project)
    {
        $project->load('tasks', 'user', 'client');

        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $users = User::all()->pluck('full_name', 'id');
        $clients = Client::all()->pluck('company_name', 'id');

        return view('projects.edit', compact('project', 'users', 'clients'));
    }

    public function update(EditProjectRequest $request, Project $project)
    {
        if ($project->user_id !== $request->user_id) {
            $user = User::find($request->user_id);

            $user->notify(new ProjectAssigned($project));
        }

        $project->update($request->validated());

        return redirect()->route('projects.index');
    }

    public function destroy(Project $project)
    {
        abort_if(Gate::denies('delete'), ResponseAlias::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            $project->delete();
        } catch (QueryException $e) {
            if($e->getCode() === '23000') {
                return redirect()->back()->with('status', 'Project belongs to task. Cannot delete.');
            }
        }

        return redirect()->route('projects.index');
    }
}
