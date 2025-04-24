@extends('layouts.admin')

@section('title', 'Project Details')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('admin.projects.index') }}" class="text-indigo-600 hover:text-indigo-800">
            &larr; Back to Projects
        </a>
    </div>
    
    @if(session('success'))
        <div class="mb-4 bg-green-100 p-4 rounded text-green-700">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="md:flex">
            <div class="md:w-1/3">
                @if($project->main_image)
                    <img src="{{ asset('storage/' . $project->main_image) }}" alt="{{ $project->title }}" class="w-full h-full object-cover">
                @else
                    <div class="bg-gray-100 h-full flex items-center justify-center p-12">
                        <svg class="w-24 h-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                @endif
            </div>
            <div class="md:w-2/3 p-6">
                <div class="flex justify-between items-start mb-4">
                    <h1 class="text-3xl font-bold">{{ $project->title }}</h1>
                    <div>
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
                    </div>
                </div>
                
                <div class="mb-6">
                    <div class="text-sm text-gray-500 mb-2">Progress</div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 mb-1">
                        <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ $project->getProgressPercentage() }}%"></div>
                    </div>
                    <div class="text-right text-sm text-gray-500">{{ $project->getProgressPercentage() }}% Complete</div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <span class="text-gray-500">Client:</span>
                        <span class="ml-2 font-medium">{{ $project->user->name }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Project Manager:</span>
                        <span class="ml-2 font-medium">{{ $project->project_manager ?? 'Not Assigned' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Start Date:</span>
                        <span class="ml-2 font-medium">{{ $project->start_date->format('M d, Y') }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Estimated Completion:</span>
                        <span class="ml-2 font-medium">{{ $project->estimated_completion_date ? $project->estimated_completion_date->format('M d, Y') : 'Not Set' }}</span>
                    </div>
                    @if($project->actual_completion_date)
                    <div>
                        <span class="text-gray-500">Actual Completion:</span>
                        <span class="ml-2 font-medium">{{ $project->actual_completion_date->format('M d, Y') }}</span>
                    </div>
                    @endif
                    <div>
                        <span class="text-gray-500">Location:</span>
                        <span class="ml-2 font-medium">{{ $project->location ?? 'Not Specified' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Budget:</span>
                        <span class="ml-2 font-medium">${{ number_format($project->budget, 2) }}</span>
                    </div>
                </div>
                
                @if($project->description)
                <div class="mt-4">
                    <h3 class="text-lg font-semibold mb-2">Description</h3>
                    <p class="text-gray-700">{{ $project->description }}</p>
                </div>
                @endif
                
                <div class="mt-6 flex">
                    <a href="{{ route('admin.projects.edit', $project) }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 mr-2">Edit Project</a>
                    <a href="{{ route('admin.projects.updates.create', $project) }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Add Progress Update</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6 border-b">
            <h2 class="text-xl font-bold">Progress Updates</h2>
        </div>
        
        @if($project->updates->isEmpty())
            <div class="p-6 text-center">
                <p class="text-gray-500">No progress updates yet. Add the first update to track project progress.</p>
            </div>
        @else
            <div class="divide-y">
                @foreach($project->updates as $update)
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-semibold">{{ $update->title }}</h3>
                            <p class="text-sm text-gray-500">{{ $update->created_at->format('M d, Y g:i A') }}</p>
                        </div>
                        <div>
                            @if($update->status == 'on_schedule')
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">On Schedule</span>
                            @elseif($update->status == 'ahead_of_schedule')
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">Ahead of Schedule</span>
                            @elseif($update->status == 'behind_schedule')
                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Behind Schedule</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <div class="text-sm text-gray-500 mb-1">Progress: {{ $update->percentage_complete }}%</div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ $update->percentage_complete }}%"></div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-gray-700">{{ $update->description }}</p>
                    </div>
                    
                    @if(!empty($update->images) && count($update->images) > 0)
                    <div class="mt-4">
                        <h4 class="font-medium mb-2">Update Images</h4>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                            @foreach($update->images as $image)
                            <a href="{{ asset('storage/' . $image) }}" target="_blank" class="block">
                                <img src="{{ asset('storage/' . $image) }}" alt="Project Update" class="h-32 w-full object-cover rounded">
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <div class="mt-4 flex text-sm">
                        <a href="{{ route('admin.projects.updates.edit', $update) }}" class="text-indigo-600 hover:text-indigo-800 mr-4">Edit Update</a>
                        <form method="POST" action="{{ route('admin.projects.updates.destroy', $update) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this update?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">Delete Update</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection