<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOperatorRequest;
use App\Http\Requests\UpdateOperatorRequest;
use Illuminate\Http\Request;

class OperatorController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Operator::query();

        if ($request->filled('room_id')) {
            $query->inRoom($request->integer('room_id'));
        }

        if ($request->filled('shift')) {
            $query->onShift($request->string('shift'));
        }

        return response()->json($query->paginate(10));
    }

    public function store(StoreOperatorRequest $request)
    {
        $validated = $request->validated();

        $operator = \App\Models\Operator::create($validated);

        return response()->json(['message' => 'Operator berhasil ditambahkan', 'data' => $operator], 201);
    }

    public function show(\App\Models\Operator $operator)
    {
        return response()->json($operator);
    }

    public function update(UpdateOperatorRequest $request, \App\Models\Operator $operator)
    {
        $validated = $request->validated();

        $operator->update($validated);

        return response()->json(['message' => 'Operator berhasil diperbarui', 'data' => $operator]);
    }

    public function destroy(\App\Models\Operator $operator)
    {
        $operator->delete();
        return response()->json(['message' => 'Operator berhasil dihapus']);
    }
}