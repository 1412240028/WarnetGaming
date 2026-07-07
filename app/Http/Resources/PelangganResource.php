<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PelangganResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'membership_id' => $this->membership_id,
            'status' => $this->status,
            'user' => new UserResource($this->whenLoaded('user')),
            'membership' => new MembershipResource($this->whenLoaded('membership')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
