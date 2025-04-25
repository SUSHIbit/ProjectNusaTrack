@extends('layouts.admin')

@section('title', 'Create Time Slot')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('admin.meetings.time-slots') }}" class="text-indigo-600 hover:text-indigo-800">
            &larr; Back to Time Slots
        </a>
    </div>
    
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Create Time Slot</h1>
        <a href="{{ route('admin.meetings.batch-time-slots') }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Batch Create Time Slots</a>
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
    
    <div class="bg-white p-6 rounded-lg shadow-md">
        <form method="POST" action="{{ route('admin.meetings.store-time-slot') }}">
            @csrf
            
            <div class="mb-4">
                <label for="date" class="block text-gray-700 font-medium mb-2">Date</label>
                <input type="date" id="date" name="date" value="{{ old('date') }}" min="{{ date('Y-m-d') }}" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="start_time" class="block text-gray-700 font-medium mb-2">Start Time</label>
                    <input type="time" id="start_time" name="start_time" value="{{ old('start_time') }}" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                
                <div>
                    <label for="end_time" class="block text-gray-700 font-medium mb-2">End Time</label>
                    <input type="time" id="end_time" name="end_time" value="{{ old('end_time') }}" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
            </div>
            
            <div class="mb-4">
                <div class="flex items-center">
                    <input type="checkbox" id="repeat" name="repeat" value="1" {{ old('repeat') ? 'checked' : '' }} class="border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                    <label for="repeat" class="ml-2 text-gray-700 font-medium">Repeat for multiple days</label>
                </div>
            </div>
            
            <div id="repeat_until_group" class="mb-4" style="{{ old('repeat') ? '' : 'display: none;' }}">
                <label for="repeat_until" class="block text-gray-700 font-medium mb-2">Repeat Until</label>
                <input type="date" id="repeat_until" name="repeat_until" value="{{ old('repeat_until') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                <p class="text-sm text-gray-500 mt-1">This will create a time slot for each day from the start date until this date.</p>
            </div>
            
            <div id="exclude_weekends_group" class="mb-4" style="{{ old('repeat') ? '' : 'display: none;' }}">
                <div class="flex items-center">
                    <input type="checkbox" id="exclude_weekends" name="exclude_weekends" value="1" {{ old('exclude_weekends') ? 'checked' : '' }} class="border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                    <label for="exclude_weekends" class="ml-2 text-gray-700 font-medium">Exclude weekends</label>
                </div>
                <p class="text-sm text-gray-500 mt-1">When checked, no time slots will be created for Saturdays and Sundays.</p>
            </div>
            
            <div class="flex justify-end">
                <a href="{{ route('admin.meetings.time-slots') }}" class="px-4 py-2 border border-gray-300 rounded text-gray-700 mr-2 hover:bg-gray-50">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Create Time Slot</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const repeatCheckbox = document.getElementById('repeat');
        const repeatUntilGroup = document.getElementById('repeat_until_group');
        const repeatUntilInput = document.getElementById('repeat_until');
        const excludeWeekendsGroup = document.getElementById('exclude_weekends_group');
        
        repeatCheckbox.addEventListener('change', function() {
            if (this.checked) {
                repeatUntilGroup.style.display = 'block';
                excludeWeekendsGroup.style.display = 'block';
                repeatUntilInput.setAttribute('required', 'required');
            } else {
                repeatUntilGroup.style.display = 'none';
                excludeWeekendsGroup.style.display = 'none';
                repeatUntilInput.removeAttribute('required');
            }
        });
        
        // Validate that end time is after start time
        document.querySelector('form').addEventListener('submit', function(e) {
            const startTime = document.getElementById('start_time').value;
            const endTime = document.getElementById('end_time').value;
            
            if (startTime >= endTime) {
                e.preventDefault();
                alert('End time must be later than start time');
            }
        });
        
        // Validate that selected date is not in the past
        document.getElementById('date').addEventListener('change', function() {
            const selectedDate = new Date(this.value);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            if (selectedDate < today) {
                alert('Cannot create time slots for past dates.');
                this.value = '';
            }
        });
    });
</script>
@endsection