<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\TimeSlot;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeetingRequestController extends Controller
{
    public function create()
    {
        // Get available states/locations in Malaysia
        $locations = Location::where('is_active', true)->orderBy('name')->get();
        
        return view('meetings.request', compact('locations'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'nullable|string',
            'location_id' => 'required|exists:locations,id',
            'proposed_date' => 'required|date|after_or_equal:today',
            'proposed_time' => 'required|string',
            'meeting_type' => 'required|in:online,in-person',
            'specific_location' => 'required_if:meeting_type,in-person|nullable|string',
        ]);
        
        // Create meeting request
        $meeting = new Meeting([
            'user_id' => Auth::id(),
            'subject' => $request->subject,
            'message' => $request->message,
            'location_id' => $request->location_id,
            'proposed_date' => $request->proposed_date,
            'proposed_time' => $request->proposed_time,
            'meeting_type' => $request->meeting_type,
            'location' => $request->specific_location,
            'status' => 'requested', // New status for requested meetings
        ]);
        
        $meeting->save();
        
        return redirect()->route('meetings.index')->with('success', 'Meeting request submitted successfully! Our team will review your request and get back to you soon.');
    }
}