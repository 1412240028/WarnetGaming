<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $room_id
 * @property string $shift
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\GamingSession> $gamingSessions
 * @property-read int|null $gaming_sessions_count
 * @property-read \App\Models\Room $room
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Operator newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Operator newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Operator query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Operator whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Operator whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Operator whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Operator whereShift($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Operator whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Operator whereUserId($value)
 * @mixin \Eloquent
 */
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

