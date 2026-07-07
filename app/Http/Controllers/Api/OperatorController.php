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

        return \App\Http\Resources\OperatorResource::collection($query->paginate(10));
    }

    public function store(StoreOperatorRequest $request)
    {
        $validated = $request->validated();

        $operator = \App\Models\Operator::create($validated);

        return (new \App\Http\Resources\OperatorResource($operator))->additional(['message' => 'Operator berhasil ditambahkan'])->response()->setStatusCode(201);
    }

    public function show(\App\Models\Operator $operator)
    {
        return new \App\Http\Resources\OperatorResource($operator);
    }

    public function update(UpdateOperatorRequest $request, \App\Models\Operator $operator)
    {
        $validated = $request->validated();

        $operator->update($validated);

        return (new \App\Http\Resources\OperatorResource($operator))->additional(['message' => 'Operator berhasil diperbarui']);
    }

    public function destroy(\App\Models\Operator $operator)
    {
        $operator->delete();
        return response()->json(['message' => 'Operator berhasil dihapus']);
    }
}