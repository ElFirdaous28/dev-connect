<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Auth::user()->projects ?? [];
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created project in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'demo_link' => 'nullable|url',
            'code_link' => 'nullable|url',
        ]);

        Project::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'demo_link' => $validated['demo_link'],
            'code_link' => $validated['code_link'],
            'user_id' => Auth::user()->id,
        ]);

        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }

    /**
     * Update the specified project in storage.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'demo_link' => 'nullable|url',
            'code_link' => 'nullable|url',
        ]);

        $project->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'demo_link' => $validated['demo_link'],
            'code_link' => $validated['code_link'],
        ]);

        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified project from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }
}
