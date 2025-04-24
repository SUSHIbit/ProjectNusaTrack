<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectUpdate extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'project_id',
        'title',
        'description',
        'percentage_complete',
        'status',
        'images',
    ];
    
    protected $casts = [
        'images' => 'array',
        'percentage_complete' => 'integer',
    ];
    
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}