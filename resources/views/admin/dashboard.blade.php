// resources/views/admin/dashboard.blade.php
@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Admin Dashboard</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-800 mb-2">Total Users</h2>
            <p class="text-3xl font-bold text-indigo-600">{{ $totalUsers }}</p>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-800 mb-2">Total Meetings</h2>
            <p class="text-3xl font-bold text-indigo-600">{{ $totalMeetings }}</p>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-800 mb-2">Pending Meetings</h2>
            <p class="text-3xl font-bold text-yellow-500">{{ $pendingMeetings }}</p>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-800 mb-2">Services</h2>
            <p class="text-3xl font-bold text-indigo-600">{{ $services }}</p>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow-md mb-8">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-semibold text-gray-800">Recent Meeting Requests</h2>
            <a href="{{ route('admin.meetings.index') }}" class="text-indigo-600 hover:text-indigo-800">View All</a>
        </div>
        
        @if($recentMeetings->isEmpty())
            <p class="text-gray-500">No recent meetings to display.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 text-left">Client</th>
                            <th class="py-3 px-4 text-left">Subject</th>
                            <th class="py-3 px-4 text-left">Date & Time</th>
                            <th class="py-3 px-4 text-left">Status</th>
                            <th class="py-3 px-4 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($recentMeetings as $meeting)
                        <tr>
                            <td class="py-3 px-4">{{ $meeting->user->name }}</td>
                            <td class="py-3 px-4">{{ $meeting->subject }}</td>
                            <td class="py-3 px-4">{{ $meeting->meeting_date->format('M d, Y g:i A') }}</td>
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
                                <a href="{{ route('admin.meetings.show', $meeting) }}" class="text-indigo-600 hover:text-indigo-800">View</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-semibold text-gray-800">Quick Links</h2>
            </div>
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('admin.meetings.time-slots') }}" class="flex items-center p-2 bg-gray-50 rounded hover:bg-gray-100">
                        <span class="mr-2">📅</span>
                        <span>Manage Time Slots</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.services') }}" class="flex items-center p-2 bg-gray-50 rounded hover:bg-gray-100">
                        <span class="mr-2">🛠️</span>
                        <span>Manage Services</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users') }}" class="flex items-center p-2 bg-gray-50 rounded hover:bg-gray-100">
                        <span class="mr-2">👥</span>
                        <span>Manage Users</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.service-categories') }}" class="flex items-center p-2 bg-gray-50 rounded hover:bg-gray-100">
                        <span class="mr-2">📂</span>
                        <span>Manage Service Categories</span>
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">System Status</h2>
            <div class="space-y-4">
                <div>
                    <span class="text-gray-600 font-medium">Server Status:</span>
                    <span class="ml-2 px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Online</span>
                </div>
                <div>
                    <span class="text-gray-600 font-medium">PHP Version:</span>
                    <span class="ml-2">{{ phpversion() }}</span>
                </div>
                <div>
                    <span class="text-gray-600 font-medium">Laravel Version:</span>
                    <span class="ml-2">{{ app()->version() }}</span>
                </div>
                <div>
                    <span class="text-gray-600 font-medium">Server Time:</span>
                    <span class="ml-2">{{ now()->format('M d, Y g:i A') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection