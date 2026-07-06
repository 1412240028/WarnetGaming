<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('session_games', function (Blueprint $table) {
            $table->id();

            $table->foreignId('gaming_session_id')->constrained('gaming_sessions')->cascadeOnDelete();
            $table->foreignId('game_id')->constrained('games')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_games');
    }
};

