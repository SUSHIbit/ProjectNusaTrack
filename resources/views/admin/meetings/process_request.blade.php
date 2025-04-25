@extends('layouts.admin')

@section('title', 'Process Meeting Request')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('admin.meetings.requests') }}" class="text-indigo-600 hover:text-indigo-800">
            &larr; Back to Meeting Requests
        </a>
    </div>
    
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Process Meeting Request</h1>
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
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2">
            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <h2 class="text-xl font-semibold mb-4">Meeting Request Details</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
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
                        <span class="text-gray-600 font-medium">Location:</span>
                        <span class="ml-2">{{ $meeting->location->name ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600 font-medium">Proposed Date:</span>
                        <span class="ml-2">{{ $meeting->proposed_date ? $meeting->proposed_date->format('l, F j, Y') : 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600 font-medium">Proposed Time:</span>
                        <span class="ml-2">{{ $meeting->proposed_time ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600 font-medium">Meeting Type:</span>
                        <span class="ml-2">{{ ucfirst($meeting->meeting_type) }}</span>
                    </div>
                    @if($meeting->location)
                    <div>
                        <span class="text-gray-600 font-medium">Specific Location:</span>
                        <span class="ml-2">{{ $meeting->location }}</span>
                    </div>
                    @endif
                    <div>
                        <span class="text-gray-600 font-medium">Requested On:</span>
                        <span class="ml-2">{{ $meeting->created_at->format('M d, Y g:i A') }}</span>
                    </div>
                </div>

                @if($meeting->message)
                <div>
                    <span class="text-gray-600 font-medium">Client Message:</span>
                    <div class="mt-2 p-3 bg-gray-50 border border-gray-200 rounded">
                        {{ $meeting->message }}
                    </div>
                </div>
                @endif
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4">Process Request</h2>
                
                <form method="POST" action="{{ route('admin.meetings.update-request', $meeting) }}" id="processForm">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="action" class="block text-gray-700 font-medium mb-2">Action</label>
                        <div class="flex space-x-4">
                            <div class="flex items-center">
                                <input type="radio" id="approve" name="action" value="approve" class="border-gray-300 text-indigo-600 focus:ring-indigo-500" checked>
                                <label for="approve" class="ml-2 text-gray-700">Approve</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="reject" name="action" value="reject" class="border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <label for="reject" class="ml-2 text-gray-700">Reject</label>
                            </div>
                        </div>
                    </div>
                    
                    <div id="time_slot_section" class="mb-4">
                        <label for="time_slot_id" class="block text-gray-700 font-medium mb-2">Select Available Time Slot</label>
                        @if($availableSlots->isEmpty())
                            <p class="text-red-500">No available time slots. Please <a href="{{ route('admin.meetings.create-time-slot') }}" class="text-indigo-600 hover:underline">create new time slots</a> first.</p>
                        @else
                            <select id="time_slot_id" name="time_slot_id" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">-- Select a time slot --</option>
                                @foreach($availableSlots as $slot)
                                    <option value="{{ $slot->id }}">
                                        {{ $slot->date->format('l, F j, Y') }} at {{ \Carbon\Carbon::parse($slot->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($slot->end_time)->format('g:i A') }}
                                    </option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                    
                    @if($meeting->meeting_type === 'online')
                    <div id="meeting_link_section" class="mb-4">
                        <label for="meeting_link" class="block text-gray-700 font-medium mb-2">Meeting Link (Required for online meetings)</label>
                        <input type="url" id="meeting_link" name="meeting_link" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    @endif
                    
                    <div class="mb-4">
                        <label for="admin_notes" class="block text-gray-700 font-medium mb-2">Admin Notes (Optional)</label>
                        <textarea id="admin_notes" name="admin_notes" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                        <p class="text-sm text-gray-500 mt-1">These notes will be visible to the client.</p>
                    </div>
                    
                    <div class="flex justify-end">
                        <a href="{{ route('admin.meetings.requests') }}" class="px-4 py-2 border border-gray-300 rounded text-gray-700 mr-2 hover:bg-gray-50">Cancel</a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Submit</button>
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
                <h2 class="text-xl font-semibold mb-4">Proposed Meeting Time</h2>
                <div class="bg-indigo-50 p-4 rounded-lg border border-indigo-100 mb-4">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-indigo-700">
                            {{ $meeting->proposed_date ? $meeting->proposed_date->format('d') : 'N/A' }}
                        </div>
                        <div class="text-lg text-indigo-600">
                            {{ $meeting->proposed_date ? $meeting->proposed_date->format('F Y') : '' }}
                        </div>
                        <div class="mt-2 text-gray-700">
                            {{ $meeting->proposed_date ? $meeting->proposed_date->format('l') : '' }}
                        </div>
                        <div class="mt-1 inline-block px-3 py-1 bg-indigo-100 rounded-full text-indigo-800">
                            {{ $meeting->proposed_time ?? 'Time not specified' }}
                        </div>
                    </div>
                </div>
                
                <div class="text-sm text-gray-600">
                    <p>If you cannot accommodate the client's proposed time, you can select an alternative time slot when approving the request.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const approveRadio = document.getElementById('approve');
    const rejectRadio = document.getElementById('reject');
    const timeSlotSection = document.getElementById('time_slot_section');
    const meetingLinkSection = document.getElementById('meeting_link_section');
    const timeSlotSelect = document.getElementById('time_slot_id');
    const meetingLink = document.getElementById('meeting_link');
    const processForm = document.getElementById('processForm');
    
    function toggleSections() {
        if (approveRadio.checked) {
            timeSlotSection.style.display = 'block';
            if (meetingLinkSection) {
                meetingLinkSection.style.display = 'block';
                meetingLink.setAttribute('required', 'required');
            }
            timeSlotSelect.setAttribute('required', 'required');
        } else {
            timeSlotSection.style.display = 'none';
            if (meetingLinkSection) {
                meetingLinkSection.style.display = 'none';
                meetingLink.removeAttribute('required');
            }
            timeSlotSelect.removeAttribute('required');
        }
    }
    
    approveRadio.addEventListener('change', toggleSections);
    rejectRadio.addEventListener('change', toggleSections);
    
    // Initial setup
    toggleSections();
    
    // Form validation before submission
    processForm.addEventListener('submit', function(e) {
        if (approveRadio.checked) {
            if (!timeSlotSelect.value) {
                e.preventDefault();
                alert('Please select a time slot when approving a meeting request.');
                return false;
            }
            
            if (meetingLinkSection && !meetingLink.value) {
                e.preventDefault();
                alert('Please provide a meeting link for online meetings.');
                return false;
            }
        }
        return true;
    });
});
</script>
@endsection