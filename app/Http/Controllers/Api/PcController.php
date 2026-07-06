<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PcController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Pc::query();

        if ($request->filled('room_id')) {
            $query->where('room_id', $request->integer('room_id'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        return response()->json($query->paginate(10));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:20',
            'status' => 'nullable|string|max:50',
            'room_id' => 'required|exists:rooms,id',
        ]);


        $pc = \App\Models\Pc::create($validated);

        return response()->json(['message' => 'PC berhasil ditambahkan', 'data' => $pc], 201);
    }

    public function show(\App\Models\Pc $pc)
    {
        return response()->json($pc);
    }

    public function update(Request $request, \App\Models\Pc $pc)
    {
        $validated = $request->validate([
            'code' => 'sometimes|required|string|max:20',
            'status' => 'sometimes|nullable|string|max:50',
            'room_id' => 'sometimes|nullable|exists:rooms,id',
        ]);


        $pc->update($validated);

        return response()->json(['message' => 'PC berhasil diperbarui', 'data' => $pc]);
    }

    public function destroy(\App\Models\Pc $pc)
    {
        $pc->delete();
        return response()->json(['message' => 'PC berhasil dihapus']);
    }
}

