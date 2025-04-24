<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'client_name',
        'client_image',
        'client_position',
        'content',
        'rating',
        'project_name'
    ];
}