@extends('layouts.admin')

@section('title', 'Manage Users')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Manage Users</h1>
    </div>
    
    @if(session('success'))
        <div class="mb-4 bg-green-100 p-4 rounded text-green-700">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="bg-white p-6 rounded-lg shadow-md">
        @if($users->isEmpty())
            <div class="text-center py-8">
                <p class="text-gray-500">No users found.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 text-left">Name</th>
                            <th class="py-3 px-4 text-left">Email</th>
                            <th class="py-3 px-4 text-left">Registered On</th>
                            <th class="py-3 px-4 text-left">Admin</th>
                            <th class="py-3 px-4 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($users as $user)
                        <tr>
                            <td class="py-3 px-4">{{ $user->name }}</td>
                            <td class="py-3 px-4">{{ $user->email }}</td>
                            <td class="py-3 px-4">{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="py-3 px-4">
                                @if($user->is_admin)
                                    <span class="px-2 py-1 bg-indigo-100 text-indigo-800 rounded-full text-xs">Admin</span>
                                @else
                                    <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs">User</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <a href="{{ route('admin.users.show', $user) }}" class="text-indigo-600 hover:text-indigo-800">View Details</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection