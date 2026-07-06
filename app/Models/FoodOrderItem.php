<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodOrderItem extends Model
{
    protected $fillable = [
        'food_order_id',
        'food_beverage_id',
        'quantity',
        'subtotal',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
    ];

    public function order()
    {
        return $this->belongsTo(FoodOrder::class, 'food_order_id');
    }

    public function foodBeverage()
    {
        return $this->belongsTo(FoodBeverage::class, 'food_beverage_id');
    }
}
