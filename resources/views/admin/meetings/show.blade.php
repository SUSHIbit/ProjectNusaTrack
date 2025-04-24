// resources/views/admin/meetings/show.blade.php
@extends('layouts.admin')

@section('title', 'Meeting Details')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('admin.meetings.index') }}" class="text-indigo-600 hover:text-indigo-800">
            &larr; Back to Meetings
        </a>
    </div>
    
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Meeting Details</h1>
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
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2">
            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <h2 class="text-xl font-semibold mb-4">Basic Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <span class="text-gray-600 font-medium">Client:</span>
                        <span class="ml-2">{{ $meeting->user->name }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600 font-medium">Email:</span>
                        <span class="ml-2">{{ $meeting->user->email }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600 font-medium">Subject:</span>
                        <span class="ml-2">{{ $meeting->subject }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600 font-medium">Status:</span>
                        <span class="ml-2">
                            @if($meeting->status == 'pending')
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">Pending</span>
                            @elseif($meeting->status == 'approved')
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Approved</span>
                            @elseif($meeting->status == 'rejected')
                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Rejected</span>
                            @elseif($meeting->status == 'completed')
                                <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs">Completed</span>
                            @endif
                        </span>
                    </div>
                    <div>
                        <span class="text-gray-600 font-medium">Date & Time:</span>
                        <span class="ml-2">{{ $meeting->meeting_date->format('l, F j, Y g:i A') }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600 font-medium">Meeting Type:</span>
                        <span class="ml-2">{{ ucfirst($meeting->meeting_type) }}</span>
                    </div>
                    @if($meeting->location)
                    <div>
                        <span class="text-gray-600 font-medium">Location:</span>
                        <span class="ml-2">{{ $meeting->location }}</span>
                    </div>
                    @endif
                    @if($meeting->meeting_link)
                    <div>
                        <span class="text-gray-600 font-medium">Meeting Link:</span>
                        <a href="{{ $meeting->meeting_link }}" target="_blank" class="ml-2 text-indigo-600 hover:text-indigo-800">{{ $meeting->meeting_link }}</a>
                    </div>
                    @endif
                    <div>
                        <span class="text-gray-600 font-medium">Requested on:</span>
                        <span class="ml-2">{{ $meeting->created_at->format('M d, Y g:i A') }}</span>
                    </div>
                </div>

                @if($meeting->message)
                <div class="mt-6">
                    <span class="text-gray-600 font-medium">Client Message:</span>
                    <div class="mt-2 p-3 bg-gray-50 border border-gray-200 rounded">
                        {{ $meeting->message }}
                    </div>
                </div>
                @endif
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4">Update Meeting Status</h2>
                
                <form method="POST" action="{{ route('admin.meetings.update', $meeting) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="status" class="block text-gray-700 font-medium mb-2">Status</label>
                        <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                            <option value="pending" {{ $meeting->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ $meeting->status == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ $meeting->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="completed" {{ $meeting->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>
                    
                    <div id="meeting_link_group" class="mb-4" style="{{ $meeting->meeting_type == 'online' ? '' : 'display: none;' }}">
                        <label for="meeting_link" class="block text-gray-700 font-medium mb-2">Meeting Link (Required for online meetings)</label>
                        <input type="url" name="meeting_link" id="meeting_link" value="{{ $meeting->meeting_link }}" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    
                    <div class="mb-4">
                        <label for="admin_notes" class="block text-gray-700 font-medium mb-2">Admin Notes</label>
                        <textarea name="admin_notes" id="admin_notes" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">{{ $meeting->admin_notes }}</textarea>
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Update Meeting</button>
                    </div>
                </form>
            </div>
        </div>
        
        <div>
            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <h2 class="text-xl font-semibold mb-4">Client Information</h2>
                <div class="text-center mb-4">
                    <div class="inline-block h-20 w-20 rounded-full bg-gray-200 flex items-center justify-center text-2xl text-gray-600 mb-2">
                        {{ substr($meeting->user->name, 0, 1) }}
                    </div>
                    <h3 class="font-semibold text-lg">{{ $meeting->user->name }}</h3>
                    <p class="text-gray-600">{{ $meeting->user->email }}</p>
                </div>
                
                <div class="mt-4">
                    <a href="{{ route('admin.users.show', $meeting->user) }}" class="block w-full text-center px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200">View Client Profile</a>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4">Meeting History</h2>
                <div class="space-y-4">
                    <div class="p-3 bg-gray-50 border-l-4 border-indigo-500 rounded">
                        <p class="text-sm text-gray-600">{{ $meeting->created_at->format('M d, Y g:i A') }}</p>
                        <p class="font-medium">Meeting requested by client</p>
                    </div>
                    
                    @if($meeting->status != 'pending')
                    <div class="p-3 bg-gray-50 border-l-4 
                        @if($meeting->status == 'approved') border-green-500 
                        @elseif($meeting->status == 'rejected') border-red-500 
                        @else border-gray-500 @endif rounded">
                        <p class="text-sm text-gray-600">{{ $meeting->updated_at->format('M d, Y g:i A') }}</p>
                        <p class="font-medium">Meeting {{ $meeting->status }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.getElementById('status');
    const meetingLinkGroup = document.getElementById('meeting_link_group');
    const meetingLink = document.getElementById('meeting_link');
    
    function toggleMeetingLink() {
        const isOnline = {{ $meeting->meeting_type === 'online' ? 'true' : 'false' }};
        const isApproved = statusSelect.value === 'approved';
        
        if (isOnline && isApproved) {
            meetingLinkGroup.style.display = 'block';
            meetingLink.setAttribute('required', 'required');
        } else {
            meetingLinkGroup.style.display = 'none';
            meetingLink.removeAttribute('required');
        }
    }
    
    statusSelect.addEventListener('change', toggleMeetingLink);
    toggleMeetingLink();
});
</script>
@endsection