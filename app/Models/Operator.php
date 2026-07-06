<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    protected $fillable = [
        'user_id',
        'room_id',
        'shift',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function gamingSessions()
    {
        return $this->hasMany(GamingSession::class, 'operator_id');
    }
}

