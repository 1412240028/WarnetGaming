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
        Schema::table('gaming_sessions', function (Blueprint $table) {
            $table->index('status', 'idx_gaming_sessions_status');
        });

        Schema::table('pcs', function (Blueprint $table) {
            $table->index('status', 'idx_pcs_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gaming_sessions', function (Blueprint $table) {
            $table->dropIndex('idx_gaming_sessions_status');
        });

        Schema::table('pcs', function (Blueprint $table) {
            $table->dropIndex('idx_pcs_status');
        });
    }
};
