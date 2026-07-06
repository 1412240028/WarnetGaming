<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'name',
        'type',
    ];

    public function pcs()
    {
        return $this->hasMany(Pc::class, 'room_id');
    }

    public function gamingSessions()
    {
        return $this->hasMany(GamingSession::class, 'room_id');
    }
}

