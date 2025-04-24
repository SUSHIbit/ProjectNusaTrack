@extends('layouts.admin')

@section('title', 'Add Project Update')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('admin.projects.show', $project) }}" class="text-indigo-600 hover:text-indigo-800">
            &larr; Back to Project
        </a>
    </div>
    
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Add Progress Update</h1>
    </div>
    
    <div class="mb-6 bg-gray-50 p-4 rounded-lg">
        <h2 class="font-bold text-lg">{{ $project->title }}</h2>
        <div class="flex items-center mt-2">
            <span class="text-gray-500 mr-2">Current Progress:</span>
            <div class="w-48 bg-gray-200 rounded-full h-2.5 mr-2">
                <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ $project->getProgressPercentage() }}%"></div>
            </div>
            <span class="text-sm">{{ $project->getProgressPercentage() }}%</span>
        </div>
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
        <form method="POST" action="{{ route('admin.projects.updates.store', $project) }}" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-medium mb-2">Update Title</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>
            
            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
                <textarea id="description" name="description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>{{ old('description') }}</textarea>
                <p class="text-sm text-gray-500 mt-1">Provide details about the current progress, challenges, and achievements.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="percentage_complete" class="block text-gray-700 font-medium mb-2">Percentage Complete</label>
                    <div class="flex items-center">
                        <input type="range" id="percentage_complete" name="percentage_complete" min="0" max="100" value="{{ old('percentage_complete', $project->getProgressPercentage()) }}" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer" oninput="updatePercentageValue(this.value)">
                        <span id="percentage_value" class="ml-2 min-w-[3rem] text-center">{{ old('percentage_complete', $project->getProgressPercentage()) }}%</span>
                    </div>
                </div>
                
                <div>
                    <label for="status" class="block text-gray-700 font-medium mb-2">Schedule Status</label>
                    <select id="status" name="status" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                        <option value="on_schedule" {{ old('status') == 'on_schedule' ? 'selected' : '' }}>On Schedule</option>
                        <option value="ahead_of_schedule" {{ old('status') == 'ahead_of_schedule' ? 'selected' : '' }}>Ahead of Schedule</option>
                        <option value="behind_schedule" {{ old('status') == 'behind_schedule' ? 'selected' : '' }}>Behind Schedule</option>
                    </select>
                </div>
            </div>
            
            <div class="mb-4">
                <label for="images" class="block text-gray-700 font-medium mb-2">Progress Images (Optional)</label>
                <input type="file" id="images" name="images[]" multiple class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" accept="image/*">
                <p class="text-sm text-gray-500 mt-1">Upload images showing the current state of the project (max 5 images, 2MB each).</p>
            </div>
            
            <div class="flex justify-end">
                <a href="{{ route('admin.projects.show', $project) }}" class="px-4 py-2 border border-gray-300 rounded text-gray-700 mr-2 hover:bg-gray-50">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Save Update</button>
            </div>
        </form>
    </div>
</div>

<script>
    function updatePercentageValue(value) {
        document.getElementById('percentage_value').textContent = value + '%';
    }
</script>
@endsection