<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodBeverage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'price',
        'stock',
        'is_available',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_available' => 'boolean',
    ];

    public function scopeAvailable($query)
    {
        return $query->where('is_available', true)->where('stock', '>', 0);
    }
}
