<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeetingController extends Controller
{
    public function index()
    {
        $meetings = Auth::user()->meetings()->orderBy('created_at', 'desc')->get();
        return view('meetings.index', compact('meetings'));
    }
    
    public function create()
    {
        $timeSlots = TimeSlot::where('is_available', true)
                    ->where('date', '>=', now()->toDateString())
                    ->orderBy('date')
                    ->orderBy('start_time')
                    ->get();
                    
        return view('meetings.create', compact('timeSlots'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'nullable|string',
            'time_slot_id' => 'required|exists:time_slots,id',
            'meeting_type' => 'required|in:online,in-person',
            'location' => 'required_if:meeting_type,in-person|nullable|string',
        ]);
        
        $timeSlot = TimeSlot::findOrFail($request->time_slot_id);
        
        if (!$timeSlot->is_available) {
            return back()->withErrors(['time_slot_id' => 'This time slot is no longer available.']);
        }
        
        $meeting = new Meeting([
            'user_id' => Auth::id(),
            'subject' => $request->subject,
            'message' => $request->message,
            'meeting_date' => $timeSlot->date->format('Y-m-d') . ' ' . $timeSlot->start_time,
            'meeting_type' => $request->meeting_type,
            'location' => $request->meeting_type === 'in-person' ? $request->location : null,
            'status' => 'pending',
        ]);
        
        $meeting->save();
        
        // Update the time slot to mark it as unavailable
        $timeSlot->update([
            'is_available' => false,
            'meeting_id' => $meeting->id,
        ]);
        
        return redirect()->route('meetings.index')->with('success', 'Meeting request submitted successfully!');
    }
    
    public function show(Meeting $meeting)
    {
        if ($meeting->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('meetings.show', compact('meeting'));
    }
    
    public function cancel(Meeting $meeting)
    {
        if ($meeting->user_id !== Auth::id()) {
            abort(403);
        }
        
        if ($meeting->status === 'completed') {
            return back()->withErrors(['meeting' => 'Completed meetings cannot be cancelled.']);
        }
        
        // Free up the time slot
        if ($meeting->timeSlot) {
            $meeting->timeSlot->update([
                'is_available' => true,
                'meeting_id' => null,
            ]);
        }
        
        $meeting->delete();
        
        return redirect()->route('meetings.index')->with('success', 'Meeting cancelled successfully.');
    }
}