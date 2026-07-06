<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $fillable = [
        'user_id',
        'membership_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function membership()
    {
        return $this->belongsTo(Membership::class, 'membership_id');
    }

    public function gamingSessions()
    {
        return $this->hasMany(GamingSession::class, 'pelanggan_id');
    }
}

