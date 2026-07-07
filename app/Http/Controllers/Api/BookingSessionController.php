<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\GamingSessionService;
use App\Http\Requests\StoreBookingSessionRequest;
use Illuminate\Http\Request;

class BookingSessionController extends Controller
{
    public function store(StoreBookingSessionRequest $request)
    {
        $validated = $request->validated();


        $service = new GamingSessionService();
        $created = $service->createActiveSession([
            'pelanggan_id' => $validated['pelanggan_id'],
            'room_id' => $validated['room_id'],
            'pc_id' => $validated['pc_id'],
            'operator_id' => $validated['operator_id'],
            'started_at' => now(),
        ]);

        return (new \App\Http\Resources\GamingSessionResource($created))->response()->setStatusCode(201);
    }
}

