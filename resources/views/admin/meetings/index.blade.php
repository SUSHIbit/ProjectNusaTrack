// resources/views/admin/meetings/index.blade.php
@extends('layouts.admin')

@section('title', 'Manage Meetings')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Manage Meetings</h1>
    </div>
    
    @if(session('success'))
        <div class="mb-4 bg-green-100 p-4 rounded text-green-700">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <div class="mb-4">
            <form method="GET" action="{{ route('admin.meetings.index') }}" class="flex space-x-4">
                <div class="flex-1">
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
                <div>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Filter</button>
                </div>
            </form>
        </div>
        
        @if($meetings->isEmpty())
            <div class="text-center py-8">
                <p class="text-gray-500">No meetings found with the selected filters.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 text-left">Client</th>
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
                            <td class="py-3 px-4">{{ $meeting->user->name }}</td>
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
            
            <div class="mt-4">
                {{ $meetings->links() }}
            </div>
        @endif
    </div>
</div>
@endsection