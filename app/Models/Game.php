<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Pc> $pcs
 * @property-read int|null $pcs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SessionGame> $sessionGames
 * @property-read int|null $session_games_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\GamingSession> $sessions
 * @property-read int|null $sessions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $userGames
 * @property-read int|null $user_games_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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

