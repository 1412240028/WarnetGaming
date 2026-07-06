<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodOrder extends Model
{
    use HasFactory;

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
