// resources/views/meetings/show.blade.php
@extends('layouts.main')

@section('title', 'Meeting Details')

@section('content')
<div class="py-12 bg-gray-100">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">Meeting Details</h1>
                    <a href="{{ route('meetings.index') }}" class="px-4 py-2 border border-gray-300 rounded text-gray-700 hover:bg-gray-50">Back to Meetings</a>
                </div>

                @if(session('success'))
                    <div class="mb-4 bg-green-100 p-4 rounded text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="bg-gray-50 p-6 rounded-lg mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h2 class="text-xl font-semibold mb-4">Basic Information</h2>
                            <div class="space-y-3">
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
                                @if($meeting->meeting_link && $meeting->status == 'approved')
                                <div>
                                    <span class="text-gray-600 font-medium">Meeting Link:</span>
                                    <a href="{{ $meeting->meeting_link }}" target="_blank" class="ml-2 text-indigo-600 hover:text-indigo-800">Join Meeting</a>
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        <div>
                            <h2 class="text-xl font-semibold mb-4">Additional Information</h2>
                            <div class="space-y-3">
                                <div>
                                    <span class="text-gray-600 font-medium">Requested on:</span>
                                    <span class="ml-2">{{ $meeting->created_at->format('M d, Y g:i A') }}</span>
                                </div>
                                @if($meeting->message)
                                <div>
                                    <span class="text-gray-600 font-medium">Your Message:</span>
                                    <div class="mt-2 p-3 bg-white border border-gray-200 rounded text-gray-700">
                                        {{ $meeting->message }}
                                    </div>
                                </div>
                                @endif
                                @if($meeting->admin_notes && ($meeting->status == 'approved' || $meeting->status == 'rejected'))
                                <div>
                                    <span class="text-gray-600 font-medium">Admin Notes:</span>
                                    <div class="mt-2 p-3 bg-white border border-gray-200 rounded text-gray-700">
                                        {{ $meeting->admin_notes }}
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                @if($meeting->status != 'completed')
                <div class="flex justify-end">
                    <form method="POST" action="{{ route('meetings.cancel', $meeting) }}" onsubmit="return confirm('Are you sure you want to cancel this meeting?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Cancel Meeting</button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection