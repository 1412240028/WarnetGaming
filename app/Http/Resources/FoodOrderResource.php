<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FoodOrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'gaming_session_id' => $this->gaming_session_id,
            'pelanggan_id' => $this->pelanggan_id,
            'operator_id' => $this->operator_id,
            'total_amount' => $this->total_amount,
            'status' => $this->status,
            'items' => FoodOrderItemResource::collection($this->whenLoaded('items')),
            'session' => new GamingSessionResource($this->whenLoaded('session')),
            'pelanggan' => new PelangganResource($this->whenLoaded('pelanggan')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
