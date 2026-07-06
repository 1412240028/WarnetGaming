<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionGame extends Model
{
    protected $fillable = [
        'gaming_session_id',
        'game_id',
    ];

    public function gamingSession()
    {
        return $this->belongsTo(GamingSession::class, 'gaming_session_id');
    }

    public function game()
    {
        return $this->belongsTo(Game::class, 'game_id');
    }
}

