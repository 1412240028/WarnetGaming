<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $gaming_session_id
 * @property int $pelanggan_id
 * @property int|null $operator_id
 * @property numeric $total_amount
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FoodOrderItem> $items
 * @property-read int|null $items_count
 * @property-read \App\Models\Operator|null $operator
 * @property-read \App\Models\Pelanggan $pelanggan
 * @property-read \App\Models\GamingSession $session
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodOrder pending()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodOrder whereGamingSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodOrder whereOperatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodOrder wherePelangganId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodOrder whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodOrder whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodOrder whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FoodOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'gaming_session_id',
        'pelanggan_id',
        'operator_id',
        'total_amount',
        'status',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function session()
    {
        return $this->belongsTo(GamingSession::class, 'gaming_session_id');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    public function operator()
    {
        return $this->belongsTo(Operator::class, 'operator_id');
    }

    public function items()
    {
        return $this->hasMany(FoodOrderItem::class, 'food_order_id');
    }
}
