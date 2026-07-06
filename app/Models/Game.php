<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'name',
    ];

    public function sessionGames()
    {
        return $this->hasMany(SessionGame::class, 'game_id');
    }

    public function sessions()
    {
        return $this->belongsToMany(GamingSession::class, 'session_games', 'game_id', 'gaming_session_id')->withTimestamps();
    }

    public function pcs()
    {
        return $this->belongsToMany(Pc::class, 'pc_games', 'game_id', 'pc_id')->withTimestamps();
    }

    public function userGames()
    {
        return $this->belongsToMany(User::class, 'user_games', 'game_id', 'user_id')->withPivot(['play_time_minutes'])->withTimestamps();
    }
}

