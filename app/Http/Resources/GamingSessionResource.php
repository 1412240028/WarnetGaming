<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GamingSessionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'pelanggan_id' => $this->pelanggan_id,
            'operator_id' => $this->operator_id,
            'pc_id' => $this->pc_id,
            'room_id' => $this->room_id,
            'started_at' => $this->started_at,
            'ended_at' => $this->ended_at,
            'status' => $this->status,
            'pelanggan' => new PelangganResource($this->whenLoaded('pelanggan')),
            'operator' => new OperatorResource($this->whenLoaded('operator')),
            'pc' => new PcResource($this->whenLoaded('pc')),
            'room' => new RoomResource($this->whenLoaded('room')),
            'games' => GameResource::collection($this->whenLoaded('games')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
