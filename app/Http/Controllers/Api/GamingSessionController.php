<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GamingSession;
use App\Services\GamingSessionService;
use App\Http\Requests\StoreGamingSessionRequest;
use Illuminate\Http\Request;

class GamingSessionController extends Controller
{
    public function index(Request $request)
    {
        $query = GamingSession::with(['pelanggan', 'pc', 'room', 'operator']);

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        // Filter cepat pakai scope: /api/gaming-sessions?only=active atau ?only=finished
        if ($request->input('only') === 'active') {
            $query->active();
        } elseif ($request->input('only') === 'finished') {
            $query->finished();
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

    public function store(StoreGamingSessionRequest $request)
    {
        $validated = $request->validated();

        $service = new GamingSessionService();
        $created = $service->createActiveSession([
            'pelanggan_id' => $validated['pelanggan_id'],
            'room_id' => $validated['room_id'],
            'pc_id' => $validated['pc_id'],
            'operator_id' => $validated['operator_id'],
            'started_at' => $validated['started_at'] ?? now(),
        ]);

        return response()->json(['message' => 'Gaming session berhasil dibuat', 'data' => $created], 201);
    }

    public function destroy(GamingSession $gamingSession)
    {
        $gamingSession->delete();
        return response()->json(['message' => 'Gaming session berhasil dihapus']);
    }
}