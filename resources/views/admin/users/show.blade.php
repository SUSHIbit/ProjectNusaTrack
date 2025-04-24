@extends('layouts.admin')

@section('title', 'User Details')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('admin.users') }}" class="text-indigo-600 hover:text-indigo-800">
            &larr; Back to Users
        </a>
    </div>
    
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">User Details</h1>
    </div>
    
    @if(session('success'))
        <div class="mb-4 bg-green-100 p-4 rounded text-green-700">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- User Profile Card -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="text-center mb-6">
                <div class="inline-block h-24 w-24 rounded-full bg-indigo-100 flex items-center justify-center text-3xl text-indigo-800 mb-4">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <h2 class="text-2xl font-semibold">{{ $user->name }}</h2>
                <p class="text-gray-600">{{ $user->email }}</p>
                
                @if($user->is_admin)
                    <div class="mt-2">
                        <span class="px-2 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm">Administrator</span>
                    </div>
                @endif
            </div>
            
            <div class="border-t border-gray-200 pt-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <span class="text-gray-500 text-sm">Registered On</span>
                        <p>{{ $user->created_at->format('M d, Y') }}</p>
                    </div>
                    
                    <div>
                        <span class="text-gray-500 text-sm">Last Login</span>
                        <p>{{ $user->updated_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- User Meetings -->
        <div class="md:col-span-2 bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Meeting History</h2>
            
            @if($meetings->isEmpty())
                <div class="text-center py-6">
                    <p class="text-gray-500">No meetings found for this user.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-3 px-4 text-left">Subject</th>
                                <th class="py-3 px-4 text-left">Date & Time</th>
                                <th class="py-3 px-4 text-left">Type</th>
                                <th class="py-3 px-4 text-left">Status</th>
                                <th class="py-3 px-4 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($meetings as $meeting)
                            <tr>
                                <td class="py-3 px-4">{{ $meeting->subject }}</td>
                                <td class="py-3 px-4">{{ $meeting->meeting_date->format('M d, Y g:i A') }}</td>
                                <td class="py-3 px-4">{{ ucfirst($meeting->meeting_type) }}</td>
                                <td class="py-3 px-4">
                                    @if($meeting->status == 'pending')
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">Pending</span>
                                    @elseif($meeting->status == 'approved')
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Approved</span>
                                    @elseif($meeting->status == 'rejected')
                                        <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Rejected</span>
                                    @elseif($meeting->status == 'completed')
                                        <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs">Completed</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    <a href="{{ route('admin.meetings.show', $meeting) }}" class="text-indigo-600 hover:text-indigo-800">View</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection