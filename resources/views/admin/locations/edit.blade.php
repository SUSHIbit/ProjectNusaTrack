@extends('layouts.admin')

@section('title', 'Edit Location')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('admin.locations.index') }}" class="text-indigo-600 hover:text-indigo-800">
            &larr; Back to Locations
        </a>
    </div>
    
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Edit Location</h1>
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
        <form method="POST" action="{{ route('admin.locations.update', $location) }}">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-medium mb-2">Location Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $location->name) }}" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>
            
            <div class="mb-4">
                <div class="flex items-center">
                    <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $location->is_active) ? 'checked' : '' }} class="border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                    <label for="is_active" class="ml-2 text-gray-700 font-medium">Active</label>
                </div>
                <p class="text-sm text-gray-500 mt-1">Only active locations will be shown to users when requesting meetings.</p>
            </div>
            
            <div class="flex justify-end">
                <a href="{{ route('admin.locations.index') }}" class="px-4 py-2 border border-gray-300 rounded text-gray-700 mr-2 hover:bg-gray-50">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Update Location</button>
            </div>
        </form>
    </div>
</div>
@endsection