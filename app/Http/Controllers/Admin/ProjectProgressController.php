<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectUpdate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectProgressController extends Controller
{
    // Project methods
    public function index()
    {
        $projects = Project::with('user')->latest()->paginate(10);
        return view('admin.projects.index', compact('projects'));
    }
    
    public function create()
    {
        $users = User::where('is_admin', false)->get();
        return view('admin.projects.create', compact('users'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'estimated_completion_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:planning,in_progress,on_hold,completed,cancelled',
            'budget' => 'nullable|numeric|min:0',
            'project_manager' => 'nullable|string|max:255',
            'main_image' => 'nullable|image|max:2048',
        ]);
        
        $data = $request->except('main_image');
        
        if ($request->hasFile('main_image')) {
            $path = $request->file('main_image')->store('projects', 'public');
            $data['main_image'] = $path;
        }
        
        $project = Project::create($data);
        
        return redirect()->route('admin.projects.show', $project)->with('success', 'Project created successfully.');
    }
    
    public function show(Project $project)
    {
        $project->load(['user', 'updates' => function($query) {
            $query->latest();
        }]);
        
        return view('admin.projects.show', compact('project'));
    }
    
    public function edit(Project $project)
    {
        $users = User::where('is_admin', false)->get();
        return view('admin.projects.edit', compact('project', 'users'));
    }
    
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'estimated_completion_date' => 'nullable|date|after_or_equal:start_date',
            'actual_completion_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:planning,in_progress,on_hold,completed,cancelled',
            'budget' => 'nullable|numeric|min:0',
            'project_manager' => 'nullable|string|max:255',
            'main_image' => 'nullable|image|max:2048',
        ]);
        
        $data = $request->except('main_image');
        
        if ($request->hasFile('main_image')) {
            // Delete old image if exists
            if ($project->main_image) {
                Storage::disk('public')->delete($project->main_image);
            }
            
            $path = $request->file('main_image')->store('projects', 'public');
            $data['main_image'] = $path;
        }
        
        $project->update($data);
        
        return redirect()->route('admin.projects.show', $project)->with('success', 'Project updated successfully.');
    }
    
    public function destroy(Project $project)
    {
        // Delete project image if exists
        if ($project->main_image) {
            Storage::disk('public')->delete($project->main_image);
        }
        
        // Delete all update images
        foreach ($project->updates as $update) {
            if (!empty($update->images)) {
                foreach ($update->images as $image) {
                    Storage::disk('public')->delete($image);
                }
            }
        }
        
        $project->delete();
        
        return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully.');
    }
    
    // Project Update methods
    public function createUpdate(Project $project)
    {
        return view('admin.projects.updates.create', compact('project'));
    }
    
    public function storeUpdate(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'percentage_complete' => 'required|integer|min:0|max:100',
            'status' => 'required|in:on_schedule,ahead_of_schedule,behind_schedule',
            'images.*' => 'nullable|image|max:2048',
        ]);
        
        $data = $request->except('images');
        
        $uploadedImages = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('project-updates', 'public');
                $uploadedImages[] = $path;
            }
        }
        
        if (!empty($uploadedImages)) {
            $data['images'] = $uploadedImages;
        }
        
        $project->updates()->create($data);
        
        // Update project status if needed
        if ($data['percentage_complete'] == 100 && $project->status != 'completed') {
            $project->update([
                'status' => 'completed',
                'actual_completion_date' => now(),
            ]);
        } elseif ($project->status == 'planning') {
            $project->update(['status' => 'in_progress']);
        }
        
        return redirect()->route('admin.projects.show', $project)->with('success', 'Project update added successfully.');
    }
    
    public function editUpdate(ProjectUpdate $update)
    {
        $project = $update->project;
        return view('admin.projects.updates.edit', compact('update', 'project'));
    }
    
    public function updateUpdate(Request $request, ProjectUpdate $update)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'percentage_complete' => 'required|integer|min:0|max:100',
            'status' => 'required|in:on_schedule,ahead_of_schedule,behind_schedule',
            'images.*' => 'nullable|image|max:2048',
            'delete_images' => 'nullable|array',
        ]);
        
        $data = $request->except(['images', 'delete_images']);
        
        // Handle image deletions
        $currentImages = $update->images ?? [];
        $deleteImages = $request->input('delete_images', []);
        
        if (!empty($deleteImages)) {
            foreach ($deleteImages as $index) {
                if (isset($currentImages[$index])) {
                    Storage::disk('public')->delete($currentImages[$index]);
                    unset($currentImages[$index]);
                }
            }
            $currentImages = array_values($currentImages); // Reindex array
        }
        
        // Add new images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('project-updates', 'public');
                $currentImages[] = $path;
            }
        }
        
        $data['images'] = $currentImages;
        
        $update->update($data);
        
        $project = $update->project;
        
        // Update project status if needed
        if ($data['percentage_complete'] == 100 && $project->status != 'completed') {
            $project->update([
                'status' => 'completed',
                'actual_completion_date' => now(),
            ]);
        }
        
        return redirect()->route('admin.projects.show', $project)->with('success', 'Project update modified successfully.');
    }
    
    public function destroyUpdate(ProjectUpdate $update)
    {
        $project = $update->project;
        
        // Delete update images if exists
        if (!empty($update->images)) {
            foreach ($update->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }
        
        $update->delete();
        
        return redirect()->route('admin.projects.show', $project)->with('success', 'Project update deleted successfully.');
    }
}