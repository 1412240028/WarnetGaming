<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'gaming_session_id',
        'method',
        'nominal',
        'status',
    ];

    public function gamingSession()
    {
        return $this->belongsTo(GamingSession::class, 'gaming_session_id');
    }
}

