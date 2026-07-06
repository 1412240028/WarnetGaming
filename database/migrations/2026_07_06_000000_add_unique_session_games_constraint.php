<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Prevent duplicate game rows per gaming session
        Schema::table('session_games', function (Blueprint $table) {
            $table->unique(['gaming_session_id', 'game_id'], 'session_games_unique_session_game');
        });
    }

    public function down(): void
    {
        Schema::table('session_games', function (Blueprint $table) {
            $table->dropUnique('session_games_unique_session_game');
        });
    }
};

