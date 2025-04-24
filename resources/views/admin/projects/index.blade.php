@extends('layouts.admin')

@section('title', 'Manage Projects')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Manage Projects</h1>
        <a href="{{ route('admin.projects.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Add New Project</a>
    </div>
    
    @if(session('success'))
        <div class="mb-4 bg-green-100 p-4 rounded text-green-700">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="bg-white p-6 rounded-lg shadow-md">
        @if($projects->isEmpty())
            <div class="text-center py-8">
                <p class="text-gray-500">No projects found. Start by adding a new project.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 text-left">Title</th>
                            <th class="py-3 px-4 text-left">Client</th>
                            <th class="py-3 px-4 text-left">Status</th>
                            <th class="py-3 px-4 text-left">Start Date</th>
                            <th class="py-3 px-4 text-left">Progress</th>
                            <th class="py-3 px-4 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($projects as $project)
                        <tr>
                            <td class="py-3 px-4">{{ $project->title }}</td>
                            <td class="py-3 px-4">{{ $project->user->name }}</td>
                            <td class="py-3 px-4">
                                @if($project->status == 'planning')
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">Planning</span>
                                @elseif($project->status == 'in_progress')
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">In Progress</span>
                                @elseif($project->status == 'on_hold')
                                    <span class="px-2 py-1 bg-orange-100 text-orange-800 rounded-full text-xs">On Hold</span>
                                @elseif($project->status == 'completed')
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Completed</span>
                                @elseif($project->status == 'cancelled')
                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Cancelled</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">{{ $project->start_date->format('M d, Y') }}</td>
                            <td class="py-3 px-4">
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ $project->getProgressPercentage() }}%"></div>
                                </div>
                                <span class="text-xs text-gray-500">{{ $project->getProgressPercentage() }}%</span>
                            </td>
                            <td class="py-3 px-4">
                                <a href="{{ route('admin.projects.show', $project) }}" class="text-indigo-600 hover:text-indigo-800 mr-2">View</a>
                                <a href="{{ route('admin.projects.edit', $project) }}" class="text-indigo-600 hover:text-indigo-800 mr-2">Edit</a>
                                <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this project?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $projects->links() }}
            </div>
        @endif
    </div>
</div>
@endsection