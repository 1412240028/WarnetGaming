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
        Schema::create('gaming_sessions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pelanggan_id')->constrained('pelanggans')->cascadeOnDelete();
            $table->foreignId('operator_id')->constrained('operators')->cascadeOnDelete();
            $table->foreignId('pc_id')->constrained('pcs')->cascadeOnDelete();

            $table->foreignId('room_id')->constrained('rooms')->cascadeOnDelete();

            $table->timestamp('started_at');
            $table->timestamp('ended_at')->nullable();

            $table->string('status')->default('active'); // active, finished

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gaming_sessions');
    }
};

