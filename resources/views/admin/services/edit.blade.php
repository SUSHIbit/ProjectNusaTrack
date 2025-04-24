@extends('layouts.admin')

@section('title', 'Edit Service')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('admin.services') }}" class="text-indigo-600 hover:text-indigo-800">
            &larr; Back to Services
        </a>
    </div>
    
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Edit Service</h1>
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
        <form method="POST" action="{{ route('admin.services.update', $service) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-medium mb-2">Service Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $service->name) }}" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>
            
            <div class="mb-4">
                <label for="service_category_id" class="block text-gray-700 font-medium mb-2">Category</label>
                <select id="service_category_id" name="service_category_id" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('service_category_id', $service->service_category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
                <textarea id="description" name="description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>{{ old('description', $service->description) }}</textarea>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Current Image</label>
                @if($service->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="h-40 object-cover rounded">
                    </div>
                @else
                    <p class="text-gray-500">No image uploaded.</p>
                @endif
                
                <label for="image" class="block text-gray-700 font-medium mt-4 mb-2">Change Image (Optional)</label>
                <input type="file" id="image" name="image" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" accept="image/*">
                <p class="text-sm text-gray-500 mt-1">Upload a new image for this service (max 2MB).</p>
            </div>
            
            <div class="flex justify-end">
                <a href="{{ route('admin.services') }}" class="px-4 py-2 border border-gray-300 rounded text-gray-700 mr-2 hover:bg-gray-50">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Update Service</button>
            </div>
        </form>
    </div>
</div>
@endsection