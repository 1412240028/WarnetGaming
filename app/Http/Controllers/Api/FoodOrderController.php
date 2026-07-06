<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FoodOrder;
use App\Models\FoodOrderItem;
use App\Models\FoodBeverage;
use App\Models\GamingSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FoodOrderController extends Controller
{
    public function index()
    {
        $orders = FoodOrder::with(['items.foodBeverage', 'session', 'pelanggan'])->get();
        return response()->json($orders);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'gaming_session_id' => 'required|exists:gaming_sessions,id',
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'items' => 'required|array|min:1',
            'items.*.food_beverage_id' => 'required|exists:food_beverages,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $session = GamingSession::findOrFail($validated['gaming_session_id']);
        if ($session->status !== 'active' && $session->status !== 'started') {
            return response()->json(['message' => 'Gaming session is not active'], 422);
        }

        $order = null;
        DB::transaction(function () use (&$order, $validated) {
            $totalAmount = 0;
            $itemsData = [];

            foreach ($validated['items'] as $item) {
                $food = FoodBeverage::lockForUpdate()->findOrFail($item['food_beverage_id']);
                
                if ($food->stock < $item['quantity']) {
                    throw new \Exception("Insufficient stock for {$food->name}");
                }

                $food->decrement('stock', $item['quantity']);
                
                $subtotal = $food->price * $item['quantity'];
                $totalAmount += $subtotal;

                $itemsData[] = [
                    'food_beverage_id' => $food->id,
                    'quantity' => $item['quantity'],
                    'subtotal' => $subtotal,
                ];
            }

            $order = FoodOrder::create([
                'gaming_session_id' => $validated['gaming_session_id'],
                'pelanggan_id' => $validated['pelanggan_id'],
                'total_amount' => $totalAmount,
                'status' => 'pending',
            ]);

            foreach ($itemsData as $data) {
                $order->items()->create($data);
            }
        });

        return response()->json($order->load('items.foodBeverage'), 201);
    }

    public function show(FoodOrder $foodOrder)
    {
        return response()->json($foodOrder->load(['items.foodBeverage', 'session', 'pelanggan']));
    }

    public function updateStatus(Request $request, FoodOrder $foodOrder)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,paid,delivered,cancelled',
        ]);

        $foodOrder->update(['status' => $validated['status']]);
        return response()->json($foodOrder);
    }
}
