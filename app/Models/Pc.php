<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pc extends Model
{
    protected $fillable = [
        'code',
        'room_id',
        'status',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function games()
    {
        return $this->belongsToMany(Game::class, 'pc_games', 'pc_id', 'game_id')->withTimestamps();
    }
}

