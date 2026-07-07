<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MembershipResource;
use App\Http\Requests\StoreMembershipRequest;
use App\Http\Requests\UpdateMembershipRequest;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Membership::query();

        if ($request->filled('level')) {
            $query->where('level', $request->string('level'));
        }

        return MembershipResource::collection($query->paginate(10));
    }

    public function store(StoreMembershipRequest $request)
    {
        $validated = $request->validated();


        $membership = \App\Models\Membership::create($validated);

        return (new MembershipResource($membership))->additional(['message' => 'Membership berhasil ditambahkan'])->response()->setStatusCode(201);
    }

    public function show(\App\Models\Membership $membership)
    {
        return new MembershipResource($membership);
    }

    public function update(UpdateMembershipRequest $request, \App\Models\Membership $membership)
    {
        $validated = $request->validated();


        $membership->update($validated);

        return (new MembershipResource($membership))->additional(['message' => 'Membership berhasil diperbarui']);
    }

    public function destroy(\App\Models\Membership $membership)
    {
        $membership->delete();
        return response()->json(['message' => 'Membership berhasil dihapus']);
    }
}

