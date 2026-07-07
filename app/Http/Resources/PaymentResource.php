<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'gaming_session_id' => $this->gaming_session_id,
            'method' => $this->method,
            'nominal' => $this->nominal,
            'status' => $this->status,
            'gaming_session' => new GamingSessionResource($this->whenLoaded('gamingSession')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
