<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $food_order_id
 * @property int $food_beverage_id
 * @property int $quantity
 * @property numeric $subtotal
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\FoodBeverage $foodBeverage
 * @property-read \App\Models\FoodOrder $order
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodOrderItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodOrderItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodOrderItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodOrderItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodOrderItem whereFoodBeverageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodOrderItem whereFoodOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodOrderItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodOrderItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodOrderItem whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodOrderItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
