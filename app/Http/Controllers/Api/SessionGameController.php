<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SessionGame;
use Illuminate\Http\Request;

class SessionGameController extends Controller
{
    public function index(Request $request, int $gamingSessionId)
    {
        $query = SessionGame::query()->where('gaming_session_id', $gamingSessionId);

        return response()->json($query->paginate(10));
    }

    public function store(Request $request, int $gamingSessionId)
    {
        $validated = $request->validate([
            'game_id' => 'required|integer|exists:games,id',
            'played_at' => 'nullable|date',
            'notes' => 'nullable|string|max:255',
        ]);

        $sessionGame = SessionGame::create(array_merge($validated, [
            'gaming_session_id' => $gamingSessionId,
        ]));

        return response()->json(['message' => 'Game ditambahkan ke session', 'data' => $sessionGame], 201);
    }
}

