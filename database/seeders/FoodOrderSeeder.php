<?php

namespace Database\Seeders;

use App\Models\FoodOrder;
use App\Models\FoodOrderItem;
use App\Models\FoodBeverage;
use App\Models\GamingSession;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FoodOrderSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $sessions = GamingSession::query()->whereNotNull('pelanggan_id')->inRandomOrder()->limit(10)->get();
        $foods = FoodBeverage::all();

        if ($sessions->isEmpty() || $foods->isEmpty()) {
            return;
        }

        foreach ($sessions as $session) {
            $foodCount = rand(1, 3);
            $totalAmount = 0;
            $itemsData = [];

            for ($i = 0; $i < $foodCount; $i++) {
                $food = $foods->random();
                $qty = rand(1, 3);
                $subtotal = $food->price * $qty;
                $totalAmount += $subtotal;

                $itemsData[] = [
                    'food_beverage_id' => $food->id,
                    'quantity' => $qty,
                    'subtotal' => $subtotal
                ];
            }

            $order = FoodOrder::query()->create([
                'gaming_session_id' => $session->id,
                'pelanggan_id' => $session->pelanggan_id,
                'operator_id' => $session->operator_id,
                'total_amount' => $totalAmount,
                'status' => ['pending', 'paid', 'delivered'][rand(0, 2)],
            ]);

            foreach ($itemsData as $item) {
                FoodOrderItem::query()->create([
                    'food_order_id' => $order->id,
                    'food_beverage_id' => $item['food_beverage_id'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['subtotal']
                ]);
            }
        }
    }
}
