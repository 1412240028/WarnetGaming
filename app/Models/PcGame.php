<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $pc_id
 * @property int $game_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Game $game
 * @property-read \App\Models\Pc $pc
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PcGame newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PcGame newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PcGame query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PcGame whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PcGame whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PcGame whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PcGame wherePcId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PcGame whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PcGame extends Model
{
    protected $fillable = [
        'pc_id',
        'game_id',
    ];

    public function pc()
    {
        return $this->belongsTo(Pc::class, 'pc_id');
    }

    public function game()
    {
        return $this->belongsTo(Game::class, 'game_id');
    }
}

