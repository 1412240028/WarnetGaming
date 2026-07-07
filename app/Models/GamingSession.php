<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $pelanggan_id
 * @property int $operator_id
 * @property int $pc_id
 * @property int $room_id
 * @property \Illuminate\Support\Carbon $started_at
 * @property \Illuminate\Support\Carbon|null $ended_at
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Game> $games
 * @property-read int|null $games_count
 * @property-read \App\Models\Operator $operator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Payment> $payments
 * @property-read int|null $payments_count
 * @property-read \App\Models\Pc $pc
 * @property-read \App\Models\Pelanggan $pelanggan
 * @property-read \App\Models\Room $room
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamingSession newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamingSession newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamingSession query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamingSession whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamingSession whereEndedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamingSession whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamingSession whereOperatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamingSession wherePcId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamingSession wherePelangganId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamingSession whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamingSession whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamingSession whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamingSession whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class GamingSession extends Model
{
    use SoftDeletes;
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
        'status' => \App\Enums\GamingSessionStatus::class,
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

    /**
     * Scope: hanya sesi yang statusnya masih berjalan (belum checkout).
     * Contoh: GamingSession::active()->get();
     */
    public function scopeActive($query)
    {
        return $query->where('status', \App\Enums\GamingSessionStatus::ACTIVE);
    }

    /**
     * Scope: hanya sesi yang sudah selesai (sudah checkout).
     * Contoh: GamingSession::finished()->get();
     */
    public function scopeFinished($query)
    {
        return $query->where('status', \App\Enums\GamingSessionStatus::FINISHED);
    }
}