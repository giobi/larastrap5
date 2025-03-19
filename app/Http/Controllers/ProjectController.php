<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Client;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::with('client')->latest()->paginate(10);
        $clients = Client::all();
        return view('projects.index', compact('projects', 'clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::all();
        return view('projects.create', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'client_id' => 'required|exists:clients,id',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        Project::create($validated);

        return redirect()->route('projects.index')
            ->with('success', 'Progetto creato con successo.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $project->load('client');
        $clients = Client::all();
        return view('projects.show', compact('project', 'clients'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $clients = Client::all();
        return view('projects.edit', compact('project', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'client_id' => 'required|exists:clients,id',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $project->update($validated);

        return redirect()->route('projects.index')
            ->with('success', 'Progetto aggiornato con successo.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Progetto eliminato con successo.');
    }
}
