// resources/views/admin/meetings/time_slots.blade.php
@extends('layouts.admin')

@section('title', 'Manage Time Slots')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Manage Time Slots</h1>
        <a href="{{ route('admin.meetings.create-time-slot') }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Create Time Slot</a>
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
    
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="mb-4">
            <form method="GET" action="{{ route('admin.meetings.time-slots') }}" class="flex space-x-4">
                <div class="flex-1">
                    <label for="date" class="block text-gray-700 font-medium mb-2">Filter by Date</label>
                    <input type="date" id="date" name="date" value="{{ request('date') }}" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div class="flex-1">
                    <label for="availability" class="block text-gray-700 font-medium mb-2">Availability</label>
                    <select id="availability" name="availability" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">All</option>
                        <option value="available" {{ request('availability') == 'available' ? 'selected' : '' }}>Available</option>
                        <option value="booked" {{ request('availability') == 'booked' ? 'selected' : '' }}>Booked</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Filter</button>
                </div>
            </form>
        </div>
        
        @if($timeSlots->isEmpty())
            <div class="text-center py-8">
                <p class="text-gray-500">No time slots found with the selected filters.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 text-left">Date</th>
                            <th class="py-3 px-4 text-left">Time</th>
                            <th class="py-3 px-4 text-left">Status</th>
                            <th class="py-3 px-4 text-left">Booked By</th>
                            <th class="py-3 px-4 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($timeSlots as $timeSlot)
                        <tr>
                            <td class="py-3 px-4">{{ $timeSlot->date->format('l, F j, Y') }}</td>
                            <td class="py-3 px-4">{{ \Carbon\Carbon::parse($timeSlot->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($timeSlot->end_time)->format('g:i A') }}</td>
                            <td class="py-3 px-4">
                                @if($timeSlot->is_available)
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Available</span>
                                @else
                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Booked</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                @if(!$timeSlot->is_available && $timeSlot->meeting && $timeSlot->meeting->user)
                                    <a href="{{ route('admin.users.show', $timeSlot->meeting->user) }}" class="text-indigo-600 hover:text-indigo-800">
                                        {{ $timeSlot->meeting->user->name }}
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                @if($timeSlot->is_available)
                                    <form method="POST" action="{{ route('admin.meetings.delete-time-slot', $timeSlot) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this time slot?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                    </form>
                                @else
                                    <a href="{{ route('admin.meetings.show', $timeSlot->meeting) }}" class="text-indigo-600 hover:text-indigo-800">View Meeting</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $timeSlots->links() }}
            </div>
        @endif
    </div>
</div>
@endsection