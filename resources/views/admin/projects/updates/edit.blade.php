@extends('layouts.admin')

@section('title', 'Edit Project Update')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('admin.projects.show', $project) }}" class="text-indigo-600 hover:text-indigo-800">
            &larr; Back to Project
        </a>
    </div>
    
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Edit Progress Update</h1>
    </div>
    
    <div class="mb-6 bg-gray-50 p-4 rounded-lg">
        <h2 class="font-bold text-lg">{{ $project->title }}</h2>
        <div class="flex items-center mt-2">
            <span class="text-gray-500 mr-2">Project Progress:</span>
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
        <form method="POST" action="{{ route('admin.projects.updates.update', $update) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-medium mb-2">Update Title</label>
                <input type="text" id="title" name="title" value="{{ old('title', $update->title) }}" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>
            
            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
                <textarea id="description" name="description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>{{ old('description', $update->description) }}</textarea>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="percentage_complete" class="block text-gray-700 font-medium mb-2">Percentage Complete</label>
                    <div class="flex items-center">
                        <input type="range" id="percentage_complete" name="percentage_complete" min="0" max="100" value="{{ old('percentage_complete', $update->percentage_complete) }}" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer" oninput="updatePercentageValue(this.value)">
                        <span id="percentage_value" class="ml-2 min-w-[3rem] text-center">{{ old('percentage_complete', $update->percentage_complete) }}%</span>
                    </div>
                </div>
                
                <div>
                    <label for="status" class="block text-gray-700 font-medium mb-2">Schedule Status</label>
                    <select id="status" name="status" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                        <option value="on_schedule" {{ old('status', $update->status) == 'on_schedule' ? 'selected' : '' }}>On Schedule</option>
                        <option value="ahead_of_schedule" {{ old('status', $update->status) == 'ahead_of_schedule' ? 'selected' : '' }}>Ahead of Schedule</option>
                        <option value="behind_schedule" {{ old('status', $update->status) == 'behind_schedule' ? 'selected' : '' }}>Behind Schedule</option>
                    </select>
                </div>
            </div>
            
            @if(!empty($update->images))
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Current Images</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                    @foreach($update->images as $index => $image)
                    <div class="relative">
                        <img src="{{ asset('storage/' . $image) }}" alt="Update Image" class="h-32 w-full object-cover rounded">
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 hover:opacity-100 bg-black bg-opacity-50 transition-opacity">
                            <div class="flex items-center">
                                <input type="checkbox" id="delete_image_{{ $index }}" name="delete_images[]" value="{{ $index }}" class="mr-2">
                                <label for="delete_image_{{ $index }}" class="text-white">Delete</label>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <p class="text-sm text-gray-500 mt-1">Hover and check the images you want to delete.</p>
            </div>
            @endif
            
            <div class="mb-4">
                <label for="images" class="block text-gray-700 font-medium mb-2">Add New Images</label>
                <input type="file" id="images" name="images[]" multiple class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" accept="image/*">
                <p class="text-sm text-gray-500 mt-1">Upload new images to add to this update (max 5 images, 2MB each).</p>
            </div>
            
            <div class="flex justify-end">
                <a href="{{ route('admin.projects.show', $project) }}" class="px-4 py-2 border border-gray-300 rounded text-gray-700 mr-2 hover:bg-gray-50">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Update</button>
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