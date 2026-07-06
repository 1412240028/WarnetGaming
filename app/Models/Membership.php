<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $fillable = [
        'level',
        'discount_percent',
        'tag',
    ];

    public function pelanggans()
    {
        return $this->hasMany(Pelanggan::class, 'membership_id');
    }
}

