<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'subject',
        'message',
        'meeting_date',
        'meeting_type',
        'location',
        'meeting_link',
        'status',
        'admin_notes',
    ];
    
    protected $casts = [
        'meeting_date' => 'datetime',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function timeSlot()
    {
        return $this->hasOne(TimeSlot::class);
    }
}