@extends('layouts.admin')

@section('title', 'Add Service Category')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('admin.service-categories') }}" class="text-indigo-600 hover:text-indigo-800">
            &larr; Back to Service Categories
        </a>
    </div>
    
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Add Service Category</h1>
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
        <form method="POST" action="{{ route('admin.service-categories.store') }}">
            @csrf
            
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-medium mb-2">Category Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>
            
            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-medium mb-2">Description (Optional)</label>
                <textarea id="description" name="description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">{{ old('description') }}</textarea>
            </div>
            
            <div class="flex justify-end">
                <a href="{{ route('admin.service-categories') }}" class="px-4 py-2 border border-gray-300 rounded text-gray-700 mr-2 hover:bg-gray-50">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Create Category</button>
            </div>
        </form>
    </div>
</div>
@endsection