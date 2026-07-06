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
        Schema::create('food_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('food_order_id')->constrained('food_orders')->cascadeOnDelete();
            $table->foreignId('food_beverage_id')->constrained('food_beverages')->cascadeOnDelete();
            $table->integer('quantity');
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food_order_items');
    }
};
