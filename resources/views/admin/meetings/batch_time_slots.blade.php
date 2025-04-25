@extends('layouts.admin')

@section('title', 'Batch Create Time Slots')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('admin.meetings.time-slots') }}" class="text-indigo-600 hover:text-indigo-800">
            &larr; Back to Time Slots
        </a>
    </div>
    
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Batch Create Time Slots</h1>
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
        <form method="POST" action="{{ route('admin.meetings.store-batch-time-slots') }}" id="batchForm">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="start_date" class="block text-gray-700 font-medium mb-2">Start Date</label>
                    <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}" min="{{ date('Y-m-d') }}" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                
                <div>
                    <label for="end_date" class="block text-gray-700 font-medium mb-2">End Date</label>
                    <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}" min="{{ date('Y-m-d') }}" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
            </div>
            
            <div class="mb-4">
                <div class="flex items-center">
                    <input type="checkbox" id="exclude_weekends" name="exclude_weekends" value="1" {{ old('exclude_weekends') ? 'checked' : '' }} class="border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                    <label for="exclude_weekends" class="ml-2 text-gray-700 font-medium">Exclude Weekends</label>
                </div>
                <p class="text-sm text-gray-500 mt-1">When checked, no time slots will be created for Saturdays and Sundays.</p>
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Time Slots to Create</label>
                <p class="text-sm text-gray-500 mb-2">Add one or more time slots that will be created for each day in the selected date range.</p>
                
                <div id="timeSlots">
                    <div class="time-slot-row flex flex-wrap items-center space-x-2 mb-2">
                        <div class="w-full md:w-auto mb-2 md:mb-0">
                            <select name="time_slots[0][start_time]" class="px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                                <option value="">Start Time</option>
                                <option value="09:00:00">9:00 AM</option>
                                <option value="10:00:00">10:00 AM</option>
                                <option value="11:00:00">11:00 AM</option>
                                <option value="13:00:00">1:00 PM</option>
                                <option value="14:00:00">2:00 PM</option>
                                <option value="15:00:00">3:00 PM</option>
                                <option value="16:00:00">4:00 PM</option>
                                <option value="17:00:00">5:00 PM</option>
                            </select>
                        </div>
                        <div class="w-full md:w-auto mb-2 md:mb-0">
                            <select name="time_slots[0][end_time]" class="px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                                <option value="">End Time</option>
                                <option value="10:00:00">10:00 AM</option>
                                <option value="11:00:00">11:00 AM</option>
                                <option value="12:00:00">12:00 PM</option>
                                <option value="14:00:00">2:00 PM</option>
                                <option value="15:00:00">3:00 PM</option>
                                <option value="16:00:00">4:00 PM</option>
                                <option value="17:00:00">5:00 PM</option>
                                <option value="18:00:00">6:00 PM</option>
                            </select>
                        </div>
                        <button type="button" class="remove-slot px-2 py-1 bg-red-100 text-red-700 rounded hover:bg-red-200" style="display: none;">Remove</button>
                    </div>
                </div>
                
                <button type="button" id="addSlot" class="mt-2 text-sm px-3 py-1 border border-indigo-300 text-indigo-600 bg-indigo-50 rounded hover:bg-indigo-100">+ Add Another Time Slot</button>
            </div>
            
            <div class="flex justify-end">
                <a href="{{ route('admin.meetings.time-slots') }}" class="px-4 py-2 border border-gray-300 rounded text-gray-700 mr-2 hover:bg-gray-50">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Create Time Slots</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const timeSlotsContainer = document.getElementById('timeSlots');
    const addSlotButton = document.getElementById('addSlot');
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    
    // Add time slot
    addSlotButton.addEventListener('click', function() {
        const slotCount = timeSlotsContainer.querySelectorAll('.time-slot-row').length;
        const newRow = document.createElement('div');
        newRow.className = 'time-slot-row flex flex-wrap items-center space-x-2 mb-2';
        
        newRow.innerHTML = `
            <div class="w-full md:w-auto mb-2 md:mb-0">
                <select name="time_slots[${slotCount}][start_time]" class="px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                    <option value="">Start Time</option>
                    <option value="09:00:00">9:00 AM</option>
                    <option value="10:00:00">10:00 AM</option>
                    <option value="11:00:00">11:00 AM</option>
                    <option value="13:00:00">1:00 PM</option>
                    <option value="14:00:00">2:00 PM</option>
                    <option value="15:00:00">3:00 PM</option>
                    <option value="16:00:00">4:00 PM</option>
                    <option value="17:00:00">5:00 PM</option>
                </select>
            </div>
            <div class="w-full md:w-auto mb-2 md:mb-0">
                <select name="time_slots[${slotCount}][end_time]" class="px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                    <option value="">End Time</option>
                    <option value="10:00:00">10:00 AM</option>
                    <option value="11:00:00">11:00 AM</option>
                    <option value="12:00:00">12:00 PM</option>
                    <option value="14:00:00">2:00 PM</option>
                    <option value="15:00:00">3:00 PM</option>
                    <option value="16:00:00">4:00 PM</option>
                    <option value="17:00:00">5:00 PM</option>
                    <option value="18:00:00">6:00 PM</option>
                </select>
            </div>
            <button type="button" class="remove-slot px-2 py-1 bg-red-100 text-red-700 rounded hover:bg-red-200">Remove</button>
        `;
        
        timeSlotsContainer.appendChild(newRow);
        
        // Show all remove buttons if there are more than one row
        if (slotCount > 0) {
            const removeButtons = timeSlotsContainer.querySelectorAll('.remove-slot');
            removeButtons.forEach(button => {
                button.style.display = 'block';
            });
        }
    });
    
    // Remove time slot
    timeSlotsContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-slot')) {
            const row = e.target.closest('.time-slot-row');
            row.remove();
            
            // Hide the remove button on the first row if it's the only row remaining
            const rows = timeSlotsContainer.querySelectorAll('.time-slot-row');
            if (rows.length === 1) {
                rows[0].querySelector('.remove-slot').style.display = 'none';
            }
            
            // Reindex the name attributes
            const allRows = timeSlotsContainer.querySelectorAll('.time-slot-row');
            allRows.forEach((row, index) => {
                const startTimeSelect = row.querySelector('select[name*="[start_time]"]');
                const endTimeSelect = row.querySelector('select[name*="[end_time]"]');
                
                startTimeSelect.name = `time_slots[${index}][start_time]`;
                endTimeSelect.name = `time_slots[${index}][end_time]`;
            });
        }
    });
    
    // Validate dates
    endDateInput.addEventListener('change', function() {
        if (startDateInput.value && this.value) {
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(this.value);
            
            if (endDate < startDate) {
                alert('End date cannot be earlier than start date');
                this.value = '';
            }
        }
    });
    
    // Validate form before submission
    document.getElementById('batchForm').addEventListener('submit', function(e) {
        const rows = timeSlotsContainer.querySelectorAll('.time-slot-row');
        
        for (let i = 0; i < rows.length; i++) {
            const startTime = rows[i].querySelector('select[name*="[start_time]"]').value;
            const endTime = rows[i].querySelector('select[name*="[end_time]"]').value;
            
            if (!startTime || !endTime) {
                e.preventDefault();
                alert('Please select both start and end times for all time slots');
                return false;
            }
            
            if (startTime >= endTime) {
                e.preventDefault();
                alert('End time must be later than start time for all time slots');
                return false;
            }
        }
        
        return true;
    });
});
</script>
@endsection