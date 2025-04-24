<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\TimeSlot;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function index()
    {
        $meetings = Meeting::with('user', 'timeSlot')
                    ->orderBy('meeting_date')
                    ->paginate(15);
                    
        return view('admin.meetings.index', compact('meetings'));
    }
    
    public function show(Meeting $meeting)
    {
        return view('admin.meetings.show', compact('meeting'));
    }
    
    public function update(Request $request, Meeting $meeting)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,completed',
            'admin_notes' => 'nullable|string',
            'meeting_link' => 'nullable|url|required_if:status,approved|required_if:meeting_type,online',
        ]);
        
        $meeting->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
            'meeting_link' => $request->meeting_link,
        ]);
        
        return redirect()->route('admin.meetings.index')->with('success', 'Meeting updated successfully.');
    }
    
    // Time Slot Management
    public function timeSlots()
    {
        $timeSlots = TimeSlot::orderBy('date')
                    ->orderBy('start_time')
                    ->paginate(20);
                    
        return view('admin.meetings.time_slots', compact('timeSlots'));
    }
    
    public function createTimeSlot()
    {
        return view('admin.meetings.create_time_slot');
    }
    
    public function storeTimeSlot(Request $request)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'repeat' => 'nullable|boolean',
            'repeat_until' => 'required_if:repeat,1|nullable|date|after:date',
        ]);
        
        $date = \Carbon\Carbon::parse($request->date);
        $endDate = $request->repeat ? \Carbon\Carbon::parse($request->repeat_until) : $date;
        
        while ($date->lte($endDate)) {
            TimeSlot::create([
                'date' => $date->format('Y-m-d'),
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'is_available' => true,
            ]);
            
            if ($request->repeat) {
                $date->addDay();
            } else {
                break;
            }
        }
        
        return redirect()->route('admin.meetings.time-slots')->with('success', 'Time slot(s) created successfully.');
    }
    
    public function deleteTimeSlot(TimeSlot $timeSlot)
    {
        if (!$timeSlot->is_available) {
            return back()->withErrors(['time_slot' => 'Cannot delete a time slot that has been booked.']);
        }
        
        $timeSlot->delete();
        
        return redirect()->route('admin.meetings.time-slots')->with('success', 'Time slot deleted successfully.');
    }
}