@extends('layouts.admin')

@section('title', 'Edit Project')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('admin.projects.show', $project) }}" class="text-indigo-600 hover:text-indigo-800">
            &larr; Back to Project
        </a>
    </div>
    
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Edit Project</h1>
    </div>
    
    @if($errors->any())
        <div class="mb-4 bg-red-100 p-4 rounded text-red-700">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <div class="bg-white p-6 rounded-lg shadow-md">
        <form method="POST" action="{{ route('admin.projects.update', $project) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="user_id" class="block text-gray-700 font-medium mb-2">Client</label>
                <select id="user_id" name="user_id" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                    <option value="">-- Select Client --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id', $project->user_id) == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-medium mb-2">Project Title</label>
                <input type="text" id="title" name="title" value="{{ old('title', $project->title) }}" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>
            
            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
                <textarea id="description" name="description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $project->description) }}</textarea>
            </div>
            
            <div class="mb-4">
                <label for="location" class="block text-gray-700 font-medium mb-2">Location</label>
                <input type="text" id="location" name="location" value="{{ old('location', $project->location) }}" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label for="start_date" class="block text-gray-700 font-medium mb-2">Start Date</label>
                    <input type="date" id="start_date" name="start_date" value="{{ old('start_date', $project->start_date->format('Y-m-d')) }}" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                
                <div>
                    <label for="estimated_completion_date" class="block text-gray-700 font-medium mb-2">Estimated Completion Date</label>
                    <input type="date" id="estimated_completion_date" name="estimated_completion_date" value="{{ old('estimated_completion_date', $project->estimated_completion_date ? $project->estimated_completion_date->format('Y-m-d') : '') }}" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                
                <div>
                    <label for="actual_completion_date" class="block text-gray-700 font-medium mb-2">Actual Completion Date</label>
                    <input type="date" id="actual_completion_date" name="actual_completion_date" value="{{ old('actual_completion_date', $project->actual_completion_date ? $project->actual_completion_date->format('Y-m-d') : '') }}" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="status" class="block text-gray-700 font-medium mb-2">Status</label>
                    <select id="status" name="status" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                        <option value="planning" {{ old('status', $project->status) == 'planning' ? 'selected' : '' }}>Planning</option>
                        <option value="in_progress" {{ old('status', $project->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="on_hold" {{ old('status', $project->status) == 'on_hold' ? 'selected' : '' }}>On Hold</option>
                        <option value="completed" {{ old('status', $project->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ old('status', $project->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                
                <div>
                    <label for="budget" class="block text-gray-700 font-medium mb-2">Budget</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <span class="text-gray-500">$</span>
                        </div>
                        <input type="number" id="budget" name="budget" value="{{ old('budget', $project->budget) }}" step="0.01" min="0" class="w-full pl-8 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>
            </div>
            
            <div class="mb-4">
                <label for="project_manager" class="block text-gray-700 font-medium mb-2">Project Manager</label>
                <input type="text" id="project_manager" name="project_manager" value="{{ old('project_manager', $project->project_manager) }}" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Main Project Image</label>
                
                @if($project->main_image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $project->main_image) }}" alt="{{ $project->title }}" class="h-40 object-cover rounded border border-gray-200">
                        <p class="text-sm text-gray-600 mt-1">Current image</p>
                    </div>
                @endif
                
                <input type="file" id="main_image" name="main_image" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" accept="image/*">
                <p class="text-sm text-gray-500 mt-1">Upload a new image to replace the current one (max 2MB).</p>
            </div>
            
            <div class="flex justify-end">
                <a href="{{ route('admin.projects.show', $project) }}" class="px-4 py-2 border border-gray-300 rounded text-gray-700 mr-2 hover:bg-gray-50">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Update Project</button>
            </div>
        </form>
    </div>
</div>
@endsection