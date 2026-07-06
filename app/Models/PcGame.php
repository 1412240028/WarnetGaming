<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

