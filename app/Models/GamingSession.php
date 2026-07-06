<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GamingSession extends Model
{
    protected $fillable = [
        'pelanggan_id',
        'operator_id',
        'pc_id',
        'room_id',
        'started_at',
        'ended_at',
        'status',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    public function operator()
    {
        return $this->belongsTo(Operator::class, 'operator_id');
    }

    public function pc()
    {
        return $this->belongsTo(Pc::class, 'pc_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'gaming_session_id');
    }

    public function games()
    {
        return $this->belongsToMany(Game::class, 'session_games', 'gaming_session_id', 'game_id')->withTimestamps();
    }
}

