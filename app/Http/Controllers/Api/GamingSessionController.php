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

        return \App\Http\Resources\GamingSessionResource::collection($query->paginate($perPage));
    }

    public function show(GamingSession $gamingSession)
    {
        return new \App\Http\Resources\GamingSessionResource($gamingSession->load(['pelanggan', 'pc', 'room', 'operator']));
    }



    public function destroy(GamingSession $gamingSession)
    {
        $gamingSession->delete();
        return response()->json(['message' => 'Gaming session berhasil dihapus']);
    }
}