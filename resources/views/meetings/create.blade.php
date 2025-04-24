@extends('layouts.main')

@section('title', 'Book a Meeting')

@section('content')
<div class="py-12 bg-gray-100">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Book a Meeting</h1>

                @if($errors->any())
                    <div class="mb-4 bg-red-100 p-4 rounded text-red-700">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if($timeSlots->isEmpty())
                    <div class="text-center py-8">
                        <p class="text-gray-500">No time slots are currently available. Please check back later.</p>
                        <a href="{{ route('meetings.index') }}" class="mt-4 inline-block px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Back to Meetings</a>
                    </div>
                @else
                    <form method="POST" action="{{ route('meetings.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="subject" class="block text-gray-700 font-medium mb-2">Meeting Subject</label>
                            <input type="text" name="subject" id="subject" value="{{ old('subject') }}" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>

                        <div class="mb-4">
                            <label for="message" class="block text-gray-700 font-medium mb-2">Message (Optional)</label>
                            <textarea name="message" id="message" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">{{ old('message') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="time_slot_id" class="block text-gray-700 font-medium mb-2">Select Time Slot</label>
                            <select name="time_slot_id" id="time_slot_id" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                                <option value="">-- Select a time slot --</option>
                                @foreach($timeSlots as $timeSlot)
                                    <option value="{{ $timeSlot->id }}" {{ old('time_slot_id') == $timeSlot->id ? 'selected' : '' }}>
                                        {{ $timeSlot->date->format('l, F j, Y') }} - {{ \Carbon\Carbon::parse($timeSlot->start_time)->format('g:i A') }} to {{ \Carbon\Carbon::parse($timeSlot->end_time)->format('g:i A') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="meeting_type" class="block text-gray-700 font-medium mb-2">Meeting Type</label>
                            <select name="meeting_type" id="meeting_type" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required onchange="toggleLocationField()">
                                <option value="">-- Select meeting type --</option>
                                <option value="online" {{ old('meeting_type') == 'online' ? 'selected' : '' }}>Online Meeting</option>
                                <option value="in-person" {{ old('meeting_type') == 'in-person' ? 'selected' : '' }}>In-Person Meeting</option>
                            </select>
                        </div>

                        <div id="location_field" class="mb-4" style="display: {{ old('meeting_type') == 'in-person' ? 'block' : 'none' }};">
                            <label for="location" class="block text-gray-700 font-medium mb-2">Meeting Location</label>
                            <input type="text" name="location" id="location" value="{{ old('location') }}" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            <p class="text-sm text-gray-500 mt-1">Please specify where you'd like the in-person meeting to take place.</p>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <a href="{{ route('meetings.index') }}" class="px-4 py-2 border border-gray-300 rounded text-gray-700 mr-2 hover:bg-gray-50">Cancel</a>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Book Meeting</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    function toggleLocationField() {
        const meetingType = document.getElementById('meeting_type').value;
        const locationField = document.getElementById('location_field');
        
        if (meetingType === 'in-person') {
            locationField.style.display = 'block';
            document.getElementById('location').setAttribute('required', 'required');
        } else {
            locationField.style.display = 'none';
            document.getElementById('location').removeAttribute('required');
        }
    }
</script>
@endsection