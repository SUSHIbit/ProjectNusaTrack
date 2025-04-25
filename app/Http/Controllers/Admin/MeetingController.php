<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\TimeSlot;
use App\Models\Location;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function index(Request $request)
    {
        $query = Meeting::with('user', 'timeSlot', 'location');

        // Apply filters
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }
        
        // Apply location filter
        if ($request->has('location_id') && $request->location_id !== '') {
            $query->where('location_id', $request->location_id);
        }

        $meetings = $query->orderBy('created_at', 'desc')->paginate(15);
        $locations = Location::where('is_active', true)->orderBy('name')->get();
        
        return view('admin.meetings.index', compact('meetings', 'locations'));
    }
    
    public function show(Meeting $meeting)
    {
        $timeSlots = TimeSlot::where('is_available', true)
                    ->where('date', '>=', now()->toDateString())
                    ->orderBy('date')
                    ->orderBy('start_time')
                    ->get();
        
        return view('admin.meetings.show', compact('meeting', 'timeSlots'));
    }
    
    public function update(Request $request, Meeting $meeting)
    {
        $request->validate([
            'status' => 'required|in:pending,requested,approved,rejected,completed',
            'admin_notes' => 'nullable|string',
            'meeting_link' => 'nullable|url|required_if:status,approved|required_if:meeting_type,online',
            'time_slot_id' => 'nullable|exists:time_slots,id',
        ]);
        
        $data = [
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
            'meeting_link' => $request->meeting_link,
        ];
        
        // If a time slot is selected and the meeting is approved, assign it
        if ($request->status === 'approved' && $request->time_slot_id) {
            $timeSlot = TimeSlot::findOrFail($request->time_slot_id);
            
            if (!$timeSlot->is_available) {
                return back()->withErrors(['time_slot_id' => 'This time slot is no longer available.']);
            }
            
            // Update the meeting date based on the time slot
            $data['meeting_date'] = $timeSlot->date->format('Y-m-d') . ' ' . $timeSlot->start_time;
            
            // Update the time slot to mark it as unavailable
            $timeSlot->update([
                'is_available' => false,
                'meeting_id' => $meeting->id,
            ]);
        }
        
        $meeting->update($data);
        
        return redirect()->route('admin.meetings.index')->with('success', 'Meeting updated successfully.');
    }
    
    // Request Management
    public function requests()
    {
        $meetings = Meeting::with('user', 'location')
                    ->where('status', 'requested')
                    ->orderBy('created_at', 'desc')
                    ->paginate(15);
                    
        return view('admin.meetings.requests', compact('meetings'));
    }
    
    public function processRequest(Meeting $meeting)
    {
        // Make sure it's a requested meeting
        if ($meeting->status !== 'requested') {
            return back()->with('error', 'This meeting is not in the requested state');
        }
        
        $availableSlots = TimeSlot::where('is_available', true)
            ->whereDate('date', '>=', now())
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();
            
        return view('admin.meetings.process_request', compact('meeting', 'availableSlots'));
    }
    
    public function updateRequest(Request $request, Meeting $meeting)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'time_slot_id' => 'required_if:action,approve|nullable|exists:time_slots,id',
            'admin_notes' => 'nullable|string',
            'meeting_link' => 'nullable|url|required_if:meeting_type,online',
        ]);
        
        if ($request->action === 'approve') {
            // Verify time slot is available
            $timeSlot = TimeSlot::findOrFail($request->time_slot_id);
            
            if (!$timeSlot->is_available) {
                return back()->withErrors(['time_slot_id' => 'This time slot is no longer available.']);
            }
            
            // Update the meeting
            $meeting->update([
                'status' => 'approved',
                'admin_notes' => $request->admin_notes,
                'meeting_link' => $request->meeting_link,
                'meeting_date' => $timeSlot->date->format('Y-m-d') . ' ' . $timeSlot->start_time,
            ]);
            
            // Update the time slot
            $timeSlot->update([
                'is_available' => false,
                'meeting_id' => $meeting->id,
            ]);
            
            return redirect()->route('admin.meetings.requests')->with('success', 'Meeting request approved successfully.');
        } 
        else { // reject
            $meeting->update([
                'status' => 'rejected',
                'admin_notes' => $request->admin_notes,
            ]);
            
            return redirect()->route('admin.meetings.requests')->with('success', 'Meeting request rejected.');
        }
    }
    
    // Time Slot Management
    public function timeSlots(Request $request)
    {
        $query = TimeSlot::query();
        
        // Filter by date
        if ($request->has('date') && !empty($request->date)) {
            $query->whereDate('date', $request->date);
        }
        
        // Filter by availability
        if ($request->has('availability') && !empty($request->availability)) {
            $query->where('is_available', $request->availability === 'available');
        }
        
        $timeSlots = $query->orderBy('date')
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
            'exclude_weekends' => 'nullable|boolean',
        ]);
        
        $date = \Carbon\Carbon::parse($request->date);
        $endDate = $request->repeat ? \Carbon\Carbon::parse($request->repeat_until) : $date;
        $excludeWeekends = $request->has('exclude_weekends');
        
        $count = 0;
        while ($date->lte($endDate)) {
            // Skip weekends if the option is selected
            if ($excludeWeekends && ($date->isWeekend())) {
                $date->addDay();
                continue;
            }
            
            TimeSlot::create([
                'date' => $date->format('Y-m-d'),
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'is_available' => true,
            ]);
            
            $count++;
            
            if ($request->repeat) {
                $date->addDay();
            } else {
                break;
            }
        }
        
        return redirect()->route('admin.meetings.time-slots')
                ->with('success', $count . ' time slot(s) created successfully.');
    }
    
    public function deleteTimeSlot(TimeSlot $timeSlot)
    {
        if (!$timeSlot->is_available) {
            return back()->withErrors(['time_slot' => 'Cannot delete a time slot that has been booked.']);
        }
        
        $timeSlot->delete();
        
        return redirect()->route('admin.meetings.time-slots')->with('success', 'Time slot deleted successfully.');
    }
    
    // Batch create time slots
    public function batchTimeSlots()
    {
        return view('admin.meetings.batch_time_slots');
    }
    
    public function storeBatchTimeSlots(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'time_slots' => 'required|array',
            'time_slots.*.start_time' => 'required',
            'time_slots.*.end_time' => 'required|after:time_slots.*.start_time',
            'exclude_weekends' => 'nullable|boolean',
        ]);
        
        $startDate = \Carbon\Carbon::parse($request->start_date);
        $endDate = \Carbon\Carbon::parse($request->end_date);
        $excludeWeekends = $request->has('exclude_weekends');
        
        $count = 0;
        $currentDate = clone $startDate;
        
        while ($currentDate->lte($endDate)) {
            // Skip weekends if the option is selected
            if ($excludeWeekends && ($currentDate->isWeekend())) {
                $currentDate->addDay();
                continue;
            }
            
            foreach ($request->time_slots as $slot) {
                TimeSlot::create([
                    'date' => $currentDate->format('Y-m-d'),
                    'start_time' => $slot['start_time'],
                    'end_time' => $slot['end_time'],
                    'is_available' => true,
                ]);
                
                $count++;
            }
            
            $currentDate->addDay();
        }
        
        return redirect()->route('admin.meetings.time-slots')
                ->with('success', $count . ' time slot(s) created successfully.');
    }
}