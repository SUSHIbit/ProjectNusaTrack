<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'date',
        'start_time',
        'end_time',
        'is_available',
        'meeting_id',
    ];
    
    protected $casts = [
        'date' => 'date',
        'is_available' => 'boolean',
    ];
    
    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }
}