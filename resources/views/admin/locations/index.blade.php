@extends('layouts.admin')

@section('title', 'Manage Locations')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Manage Locations</h1>
        <a href="{{ route('admin.locations.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Add New Location</a>
    </div>
    
    @if(session('success'))
        <div class="mb-4 bg-green-100 p-4 rounded text-green-700">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="mb-4 bg-red-100 p-4 rounded text-red-700">
            {{ session('error') }}
        </div>
    @endif
    
    <div class="bg-white p-6 rounded-lg shadow-md">
        @if($locations->isEmpty())
            <div class="text-center py-8">
                <p class="text-gray-500">No locations found. Start by adding a new location.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 text-left">Name</th>
                            <th class="py-3 px-4 text-left">Status</th>
                            <th class="py-3 px-4 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($locations as $location)
                        <tr>
                            <td class="py-3 px-4">{{ $location->name }}</td>
                            <td class="py-3 px-4">
                                @if($location->is_active)
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Active</span>
                                @else
                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Inactive</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <a href="{{ route('admin.locations.edit', $location) }}" class="text-indigo-600 hover:text-indigo-800 mr-2">Edit</a>
                                <form method="POST" action="{{ route('admin.locations.destroy', $location) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this location?')">
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
                {{ $locations->links() }}
            </div>
        @endif
    </div>
</div>
@endsection