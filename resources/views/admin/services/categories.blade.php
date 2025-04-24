@extends('layouts.admin')

@section('title', 'Manage Service Categories')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Manage Service Categories</h1>
        <a href="{{ route('admin.service-categories.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Add New Category</a>
    </div>
    
    @if(session('success'))
        <div class="mb-4 bg-green-100 p-4 rounded text-green-700">
            {{ session('success') }}
        </div>
    @endif
    
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
        @if($categories->isEmpty())
            <div class="text-center py-8">
                <p class="text-gray-500">No service categories found. Start by adding a new category.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 text-left">Name</th>
                            <th class="py-3 px-4 text-left">Description</th>
                            <th class="py-3 px-4 text-left">Services Count</th>
                            <th class="py-3 px-4 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($categories as $category)
                        <tr>
                            <td class="py-3 px-4">{{ $category->name }}</td>
                            <td class="py-3 px-4">{{ \Illuminate\Support\Str::limit($category->description, 100) }}</td>
                            <td class="py-3 px-4">{{ $category->services_count }}</td>
                            <td class="py-3 px-4">
                                <a href="{{ route('admin.service-categories.edit', $category) }}" class="text-indigo-600 hover:text-indigo-800 mr-2">Edit</a>
                                <form method="POST" action="{{ route('admin.service-categories.delete', $category) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this category?')">
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
                {{ $categories->links() }}
            </div>
        @endif
    </div>
</div>
@endsection