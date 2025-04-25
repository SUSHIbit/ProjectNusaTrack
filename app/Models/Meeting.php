<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'location_id',
        'subject',
        'message',
        'meeting_date',
        'proposed_date',
        'proposed_time',
        'meeting_type',
        'location',
        'meeting_link',
        'status',
        'admin_notes',
    ];
    
    protected $casts = [
        'meeting_date' => 'datetime',
        'proposed_date' => 'date',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function timeSlot()
    {
        return $this->hasOne(TimeSlot::class);
    }
    
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}