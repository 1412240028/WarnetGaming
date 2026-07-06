<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Membership::query();

        if ($request->filled('level')) {
            $query->where('level', $request->string('level'));
        }


        return response()->json($query->paginate(10));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'level' => 'required|string|max:50',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'tag' => 'nullable|string|max:50',
        ]);


        $membership = \App\Models\Membership::create($validated);

        return response()->json(['message' => 'Membership berhasil ditambahkan', 'data' => $membership], 201);
    }

    public function show(\App\Models\Membership $membership)
    {
        return response()->json($membership);
    }

    public function update(Request $request, \App\Models\Membership $membership)
    {
        $validated = $request->validate([
            'level' => 'sometimes|required|string|max:50',
            'discount_percent' => 'sometimes|nullable|numeric|min:0|max:100',
            'tag' => 'sometimes|nullable|string|max:50',
        ]);


        $membership->update($validated);

        return response()->json(['message' => 'Membership berhasil diperbarui', 'data' => $membership]);
    }

    public function destroy(\App\Models\Membership $membership)
    {
        $membership->delete();
        return response()->json(['message' => 'Membership berhasil dihapus']);
    }
}

