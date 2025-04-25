@extends('layouts.main')

@section('title', 'Request a Meeting')

@section('content')
<div class="py-12 bg-gray-100">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Request a Meeting</h1>

                @if($errors->any())
                    <div class="mb-4 bg-red-100 p-4 rounded text-red-700">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('meetings.request.store') }}">
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
                        <label for="location_id" class="block text-gray-700 font-medium mb-2">State/Location</label>
                        <select name="location_id" id="location_id" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                            <option value="">-- Select a location --</option>
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '' }}>
                                    {{ $location->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="proposed_date" class="block text-gray-700 font-medium mb-2">Proposed Date</label>
                            <input type="date" id="proposed_date" name="proposed_date" value="{{ old('proposed_date') }}" min="{{ date('Y-m-d') }}" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                            <p class="text-sm text-gray-500 mt-1">Please note that meetings cannot be scheduled on weekends.</p>
                        </div>
                        
                        <div>
                            <label for="proposed_time" class="block text-gray-700 font-medium mb-2">Proposed Time</label>
                            <select id="proposed_time" name="proposed_time" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                                <option value="">-- Select a time --</option>
                                <option value="09:00 AM" {{ old('proposed_time') == '09:00 AM' ? 'selected' : '' }}>9:00 AM</option>
                                <option value="10:00 AM" {{ old('proposed_time') == '10:00 AM' ? 'selected' : '' }}>10:00 AM</option>
                                <option value="11:00 AM" {{ old('proposed_time') == '11:00 AM' ? 'selected' : '' }}>11:00 AM</option>
                                <option value="01:00 PM" {{ old('proposed_time') == '01:00 PM' ? 'selected' : '' }}>1:00 PM</option>
                                <option value="02:00 PM" {{ old('proposed_time') == '02:00 PM' ? 'selected' : '' }}>2:00 PM</option>
                                <option value="03:00 PM" {{ old('proposed_time') == '03:00 PM' ? 'selected' : '' }}>3:00 PM</option>
                                <option value="04:00 PM" {{ old('proposed_time') == '04:00 PM' ? 'selected' : '' }}>4:00 PM</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="meeting_type" class="block text-gray-700 font-medium mb-2">Meeting Type</label>
                        <select name="meeting_type" id="meeting_type" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required onchange="toggleLocationField()">
                            <option value="">-- Select meeting type --</option>
                            <option value="online" {{ old('meeting_type') == 'online' ? 'selected' : '' }}>Online Meeting</option>
                            <option value="in-person" {{ old('meeting_type') == 'in-person' ? 'selected' : '' }}>In-Person Meeting</option>
                        </select>
                    </div>

                    <div id="specific_location_field" class="mb-4" style="display: {{ old('meeting_type') == 'in-person' ? 'block' : 'none' }};">
                        <label for="specific_location" class="block text-gray-700 font-medium mb-2">Specific Meeting Location</label>
                        <input type="text" name="specific_location" id="specific_location" value="{{ old('specific_location') }}" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <p class="text-sm text-gray-500 mt-1">Please specify where you'd like the in-person meeting to take place (e.g., your home, office, project site).</p>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('services') }}" class="px-4 py-2 border border-gray-300 rounded text-gray-700 mr-2 hover:bg-gray-50">Cancel</a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Submit Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleLocationField() {
        const meetingType = document.getElementById('meeting_type').value;
        const locationField = document.getElementById('specific_location_field');
        
        if (meetingType === 'in-person') {
            locationField.style.display = 'block';
            document.getElementById('specific_location').setAttribute('required', 'required');
        } else {
            locationField.style.display = 'none';
            document.getElementById('specific_location').removeAttribute('required');
        }
    }
    
    // Validate that selected date is not a weekend
    document.getElementById('proposed_date').addEventListener('change', function() {
        const selectedDate = new Date(this.value);
        const day = selectedDate.getDay();
        
        // 0 is Sunday, 6 is Saturday
        if (day === 0 || day === 6) {
            alert('Meetings cannot be scheduled on weekends. Please select a weekday.');
            this.value = '';
        }
    });
</script>
@endsection