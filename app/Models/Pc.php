<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $code
 * @property int $room_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Game> $games
 * @property-read int|null $games_count
 * @property-read \App\Models\Room $room
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pc newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pc newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pc query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pc whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pc whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pc whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pc whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pc whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pc whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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

