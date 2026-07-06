<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::query()->with('pcs', 'gamingSessions');

        if ($request->filled('type')) {
            $query->where('type', $request->string('type'));
        }

        return response()->json($query->paginate(10));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([

            'name' => 'required|string|max:50',
            'type' => 'nullable|string|max:30',
        ]);

        $room = null;
        DB::transaction(function () use (&$room, $validated) {
            $room = Room::create($validated);
        });

        return response()->json(['message' => 'Room berhasil ditambahkan', 'data' => $room], 201);
    }

    public function show(Room $room)
    {
        $room->load('pcs', 'gamingSessions');
        return response()->json($room);
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([

            'name' => 'sometimes|required|string|max:50',
            'type' => 'sometimes|nullable|string|max:30',
        ]);

        DB::transaction(function () use ($room, $validated) {
            $room->update($validated);
        });

        return response()->json(['message' => 'Room berhasil diperbarui', 'data' => $room]);
    }

    public function destroy(Request $request, Room $room)
    {
        DB::transaction(function () use ($room) {

            $room->delete();
        });

        return response()->json(['message' => 'Room berhasil dihapus']);
    }
}