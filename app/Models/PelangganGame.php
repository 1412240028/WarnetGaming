<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property-read \App\Models\Game|null $game
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PelangganGame newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PelangganGame newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PelangganGame query()
 * @mixin \Eloquent
 */
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


