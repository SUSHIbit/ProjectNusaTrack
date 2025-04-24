<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HousePricing extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'house_type',
        'name',
        'description',
        'total_price',
        'deposit_amount',
        'balance_amount',
        'image',
        'is_available'
    ];
    
    protected $casts = [
        'total_price' => 'decimal:2',
        'deposit_amount' => 'decimal:2',
        'balance_amount' => 'decimal:2',
        'is_available' => 'boolean',
    ];
    
    // Calculate balance based on total and deposit
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function($model) {
            if (isset($model->total_price) && isset($model->deposit_amount)) {
                $model->balance_amount = $model->total_price - $model->deposit_amount;
            }
        });
        
        static::updating(function($model) {
            if (isset($model->total_price) && isset($model->deposit_amount)) {
                $model->balance_amount = $model->total_price - $model->deposit_amount;
            }
        });
    }
}