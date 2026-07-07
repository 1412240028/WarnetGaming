<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Http\Requests\StorePelangganRequest;
use App\Http\Requests\UpdatePelangganRequest;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return \App\Http\Resources\PelangganResource::collection(Pelanggan::with(['user', 'membership'])->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePelangganRequest $request)
    {
        $validated = $request->validated();

        $pelanggan = Pelanggan::create($validated);

        return (new \App\Http\Resources\PelangganResource($pelanggan))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pelanggan = Pelanggan::with(['user', 'membership'])->findOrFail($id);
        return new \App\Http\Resources\PelangganResource($pelanggan);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePelangganRequest $request, string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        $validated = $request->validated();

        $pelanggan->update($validated);

        return new \App\Http\Resources\PelangganResource($pelanggan);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();

        return response()->json(null, 204);
    }
}
