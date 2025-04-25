@extends('layouts.admin')

@section('title', 'Meeting Requests')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Meeting Requests</h1>
    </div>
    
    @if(session('success'))
        <div class="mb-4 bg-green-100 p-4 rounded text-green-700">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <div class="mb-4">
            <form method="GET" action="{{ route('admin.meetings.requests') }}" class="flex space-x-4">
                <div class="flex-1">
                    <select name="location_id" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">All Locations</option>
                        @foreach($locations ?? [] as $location)
                            <option value="{{ $location->id }}" {{ request('location_id') == $location->id ? 'selected' : '' }}>{{ $location->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Filter</button>
                </div>
            </form>
        </div>
        
        @if($meetings->isEmpty())
            <div class="text-center py-8">
                <p class="text-gray-500">No meeting requests found with the selected filters.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 text-left">Client</th>
                            <th class="py-3 px-4 text-left">Subject</th>
                            <th class="py-3 px-4 text-left">Location</th>
                            <th class="py-3 px-4 text-left">Proposed Date</th>
                            <th class="py-3 px-4 text-left">Proposed Time</th>
                            <th class="py-3 px-4 text-left">Type</th>
                            <th class="py-3 px-4 text-left">Requested On</th>
                            <th class="py-3 px-4 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($meetings as $meeting)
                        <tr>
                            <td class="py-3 px-4">{{ $meeting->user->name }}</td>
                            <td class="py-3 px-4">{{ $meeting->subject }}</td>
                            <td class="py-3 px-4">{{ $meeting->location->name ?? 'N/A' }}</td>
                            <td class="py-3 px-4">{{ $meeting->proposed_date ? $meeting->proposed_date->format('M d, Y') : 'N/A' }}</td>
                            <td class="py-3 px-4">{{ $meeting->proposed_time ?? 'N/A' }}</td>
                            <td class="py-3 px-4">{{ ucfirst($meeting->meeting_type) }}</td>
                            <td class="py-3 px-4">{{ $meeting->created_at->format('M d, Y') }}</td>
                            <td class="py-3 px-4">
                                <a href="{{ route('admin.meetings.process-request', $meeting) }}" class="text-indigo-600 hover:text-indigo-800">Process</a>
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