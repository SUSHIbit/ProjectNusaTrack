@extends('layouts.main')

@section('title', 'My Meetings')

@section('content')
<div class="py-12 bg-gray-100">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">My Meetings</h1>
                    <a href="{{ route('meetings.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Book New Meeting</a>
                </div>

                @if(session('success'))
                    <div class="mb-4 bg-green-100 p-4 rounded text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if($meetings->isEmpty())
                    <div class="text-center py-8">
                        <p class="text-gray-500">You don't have any scheduled meetings yet.</p>
                        <a href="{{ route('meetings.create') }}" class="mt-4 inline-block px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Book Your First Meeting</a>
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
                                        <a href="{{ route('meetings.show', $meeting) }}" class="text-indigo-600 hover:text-indigo-800">View</a>
                                        
                                        @if($meeting->status != 'completed')
                                        <form class="inline-block ml-2" method="POST" action="{{ route('meetings.cancel', $meeting) }}" onsubmit="return confirm('Are you sure you want to cancel this meeting?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">Cancel</button>
                                        </form>
                                        @endif
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
</div>
@endsection