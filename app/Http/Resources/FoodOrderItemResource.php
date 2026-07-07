<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FoodOrderItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'food_order_id' => $this->food_order_id,
            'food_beverage_id' => $this->food_beverage_id,
            'quantity' => $this->quantity,
            'subtotal' => $this->subtotal,
            'food_beverage' => new FoodBeverageResource($this->whenLoaded('foodBeverage')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
