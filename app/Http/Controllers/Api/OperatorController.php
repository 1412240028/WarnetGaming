<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OperatorController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Operator::query();

        if ($request->filled('room_id')) {
            $query->where('room_id', $request->integer('room_id'));
        }

        if ($request->filled('shift')) {
            $query->where('shift', $request->string('shift'));
        }

        return response()->json($query->paginate(10));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'shift' => 'nullable|string|max:30',
            'room_id' => 'nullable|exists:rooms,id',
        ]);

        $operator = \App\Models\Operator::create($validated);

        return response()->json(['message' => 'Operator berhasil ditambahkan', 'data' => $operator], 201);
    }

    public function show(\App\Models\Operator $operator)
    {
        return response()->json($operator);
    }

    public function update(Request $request, \App\Models\Operator $operator)
    {
        $validated = $request->validate([
            'user_id' => 'sometimes|required|exists:users,id',
            'shift' => 'sometimes|nullable|string|max:30',
            'room_id' => 'sometimes|nullable|exists:rooms,id',
        ]);

        $operator->update($validated);

        return response()->json(['message' => 'Operator berhasil diperbarui', 'data' => $operator]);
    }

    public function destroy(\App\Models\Operator $operator)
    {
        $operator->delete();
        return response()->json(['message' => 'Operator berhasil dihapus']);
    }
}

