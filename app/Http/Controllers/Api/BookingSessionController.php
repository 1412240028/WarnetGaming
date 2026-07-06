<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GamingSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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


        $created = null;
        DB::transaction(function () use (&$created, $validated) {
            // TODO: implement race-condition safety and PC availability check
            $created = GamingSession::create([
                'pelanggan_id' => $validated['pelanggan_id'],
                'room_id' => $validated['room_id'],
                'pc_id' => $validated['pc_id'],
                'operator_id' => $validated['operator_id'],
                'status' => 'active',
                'started_at' => now(),
            ]);

        });

        return response()->json($created, 201);
    }
}

