<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PelangganGame extends Model
{
    protected $fillable = [
        'user_id',
        'game_id',
        'play_time_minutes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function game()
    {
        return $this->belongsTo(Game::class, 'game_id');
    }
}


