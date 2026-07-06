<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GamingSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GamingSessionController extends Controller
{
    public function index(Request $request)
    {
        $query = GamingSession::with(['pelanggan', 'pc', 'room', 'operator']);

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        if ($request->filled('room_id')) {
            $query->where('room_id', $request->integer('room_id'));
        }

        $perPage = $request->input('per_page', 10);
        if (!is_numeric($perPage) || $perPage < 1 || $perPage > 100) {
            $perPage = 10;
        }

        return response()->json($query->paginate($perPage));
    }

    public function show(GamingSession $gamingSession)
    {
        return response()->json($gamingSession->load(['pelanggan', 'pc', 'room', 'operator']));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'room_id' => 'required|exists:rooms,id',
            'pc_id' => 'required|exists:pcs,id',
            'operator_id' => 'required|exists:operators,id',
            'started_at' => 'nullable|date',
        ]);

        $created = null;
        DB::transaction(function () use (&$created, $validated) {
            $created = GamingSession::create(array_merge($validated, [
                'status' => 'active',
                'started_at' => $validated['started_at'] ?? now(),
            ]));
        });

        return response()->json(['message' => 'Gaming session berhasil dibuat', 'data' => $created], 201);
    }

    public function destroy(GamingSession $gamingSession)
    {
        $gamingSession->delete();
        return response()->json(['message' => 'Gaming session berhasil dihapus']);
    }
}

