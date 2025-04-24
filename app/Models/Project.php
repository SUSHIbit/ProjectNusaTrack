<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'location',
        'start_date',
        'estimated_completion_date',
        'actual_completion_date',
        'status',
        'budget',
        'project_manager',
        'main_image',
    ];
    
    protected $casts = [
        'start_date' => 'date',
        'estimated_completion_date' => 'date',
        'actual_completion_date' => 'date',
        'budget' => 'decimal:2',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function updates()
    {
        return $this->hasMany(ProjectUpdate::class);
    }
    
    public function getLatestUpdate()
    {
        return $this->updates()->latest()->first();
    }
    
    public function getProgressPercentage()
    {
        $latestUpdate = $this->getLatestUpdate();
        
        if ($latestUpdate) {
            return $latestUpdate->percentage_complete;
        }
        
        return 0;
    }
}