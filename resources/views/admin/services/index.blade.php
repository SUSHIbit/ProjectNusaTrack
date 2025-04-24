// resources/views/admin/services/index.blade.php
@extends('layouts.admin')

@section('title', 'Manage Services')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Manage Services</h1>
        <a href="{{ route('admin.services.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Add New Service</a>
    </div>
    
    @if(session('success'))
        <div class="mb-4 bg-green-100 p-4 rounded text-green-700">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="bg-white p-6 rounded-lg shadow-md">
        @if($services->isEmpty())
            <div class="text-center py-8">
                <p class="text-gray-500">No services found. Start by adding a new service.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 text-left">Name</th>
                            <th class="py-3 px-4 text-left">Category</th>
                            <th class="py-3 px-4 text-left">Description</th>
                            <th class="py-3 px-4 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($services as $service)
                        <tr>
                            <td class="py-3 px-4">{{ $service->name }}</td>
                            <td class="py-3 px-4">{{ $service->category->name }}</td>
                            <td class="py-3 px-4">{{ \Illuminate\Support\Str::limit($service->description, 100) }}</td>
                            <td class="py-3 px-4">
                                <a href="{{ route('admin.services.edit', $service) }}" class="text-indigo-600 hover:text-indigo-800 mr-2">Edit</a>
                                <form method="POST" action="{{ route('admin.services.delete', $service) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this service?')">
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
                {{ $services->links() }}
            </div>
        @endif
    </div>
</div>
@endsection