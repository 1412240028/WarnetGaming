<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $category
 * @property numeric $price
 * @property int $stock
 * @property bool $is_available
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodBeverage available()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodBeverage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodBeverage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodBeverage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodBeverage whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodBeverage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodBeverage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodBeverage whereIsAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodBeverage whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodBeverage wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodBeverage whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodBeverage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
