<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
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

        return \App\Http\Resources\RoomResource::collection($query->paginate(10));
    }

    public function store(StoreRoomRequest $request)
    {
        $validated = $request->validated();

        $room = null;
        DB::transaction(function () use (&$room, $validated) {
            $room = Room::create($validated);
        });

        return (new \App\Http\Resources\RoomResource($room))->additional(['message' => 'Room berhasil ditambahkan'])->response()->setStatusCode(201);
    }

    public function show(Room $room)
    {
        $room->load('pcs', 'gamingSessions');
        return new \App\Http\Resources\RoomResource($room);
    }

    public function update(UpdateRoomRequest $request, Room $room)
    {
        $validated = $request->validated();

        DB::transaction(function () use ($room, $validated) {
            $room->update($validated);
        });

        return (new \App\Http\Resources\RoomResource($room))->additional(['message' => 'Room berhasil diperbarui']);
    }

    public function destroy(Request $request, Room $room)
    {
        DB::transaction(function () use ($room) {

            $room->delete();
        });

        return response()->json(['message' => 'Room berhasil dihapus']);
    }
}