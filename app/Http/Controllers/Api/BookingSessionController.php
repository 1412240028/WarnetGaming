<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\GamingSessionService;
use Illuminate\Http\Request;

class BookingSessionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'room_id' => 'required|exists:rooms,id',
            'pc_id' => 'required|exists:pcs,id',
            'operator_id' => 'required|exists:operators,id',
        ]);


        $service = new GamingSessionService();
        $created = $service->createActiveSession([
            'pelanggan_id' => $validated['pelanggan_id'],
            'room_id' => $validated['room_id'],
            'pc_id' => $validated['pc_id'],
            'operator_id' => $validated['operator_id'],
            'started_at' => now(),
        ]);

        return response()->json($created, 201);
    }
}

