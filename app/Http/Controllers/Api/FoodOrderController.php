<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FoodOrder;
use App\Models\FoodOrderItem;
use App\Models\FoodBeverage;
use App\Models\GamingSession;
use App\Http\Requests\StoreFoodOrderRequest;
use App\Http\Requests\UpdateFoodOrderStatusRequest;
use App\Exceptions\InsufficientStockException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FoodOrderController extends Controller
{
    public function index()
    {
        $orders = FoodOrder::with(['items.foodBeverage', 'session', 'pelanggan'])->get();
        return \App\Http\Resources\FoodOrderResource::collection($orders);
    }

    public function store(StoreFoodOrderRequest $request)
    {
        $validated = $request->validated();

        $session = GamingSession::findOrFail($validated['gaming_session_id']);
        if ($session->status !== \App\Enums\GamingSessionStatus::ACTIVE) {
            return response()->json(['message' => 'Gaming session is not active'], 422);
        }

        $order = null;
        DB::transaction(function () use (&$order, $validated) {
            $totalAmount = 0;
            $itemsData = [];

            foreach ($validated['items'] as $item) {
                $food = FoodBeverage::lockForUpdate()->findOrFail($item['food_beverage_id']);
                
                if ($food->stock < $item['quantity']) {
                    throw new InsufficientStockException(
                        $food->name,
                        $food->stock,
                        $item['quantity']
                    );
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

        return (new \App\Http\Resources\FoodOrderResource($order->load('items.foodBeverage')))->response()->setStatusCode(201);
    }

    public function show(FoodOrder $foodOrder)
    {
        return new \App\Http\Resources\FoodOrderResource($foodOrder->load(['items.foodBeverage', 'session', 'pelanggan']));
    }

    public function updateStatus(UpdateFoodOrderStatusRequest $request, FoodOrder $foodOrder)
    {
        $foodOrder->update(['status' => $request->validated('status')]);
        return new \App\Http\Resources\FoodOrderResource($foodOrder);
    }
}
