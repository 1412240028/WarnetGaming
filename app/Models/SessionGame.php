<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $gaming_session_id
 * @property int $game_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Game $game
 * @property-read \App\Models\GamingSession $gamingSession
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SessionGame newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SessionGame newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SessionGame query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SessionGame whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SessionGame whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SessionGame whereGamingSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SessionGame whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SessionGame whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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

