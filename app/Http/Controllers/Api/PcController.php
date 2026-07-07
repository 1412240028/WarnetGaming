<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PcResource;
use App\Http\Requests\StorePcRequest;
use App\Http\Requests\UpdatePcRequest;
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

        return PcResource::collection($query->paginate(10));
    }

    public function store(StorePcRequest $request)
    {
        $validated = $request->validated();


        $pc = \App\Models\Pc::create($validated);

        return (new PcResource($pc))->additional(['message' => 'PC berhasil ditambahkan'])->response()->setStatusCode(201);
    }

    public function show(\App\Models\Pc $pc)
    {
        return new PcResource($pc->load('room'));
    }

    public function update(UpdatePcRequest $request, \App\Models\Pc $pc)
    {
        $validated = $request->validated();


        $pc->update($validated);

        return (new PcResource($pc))->additional(['message' => 'PC berhasil diperbarui']);
    }

    public function destroy(\App\Models\Pc $pc)
    {
        $pc->delete();
        return response()->json(['message' => 'PC berhasil dihapus']);
    }
}

