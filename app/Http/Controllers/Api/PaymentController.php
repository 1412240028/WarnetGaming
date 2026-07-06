<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Payment::query();

        if ($request->filled('method')) {
            $query->where('method', $request->string('method'));
        }


        return response()->json($query->paginate(10));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'gaming_session_id' => 'required|exists:gaming_sessions,id',
            'nominal' => 'required|numeric|min:0',
            'method' => 'required|in:cash,qris,transfer,member',
        ]);


        $payment = \App\Models\Payment::create($validated);

        return response()->json(['message' => 'Payment berhasil dibuat', 'data' => $payment], 201);
    }

    public function show(\App\Models\Payment $payment)
    {
        return response()->json($payment);
    }

    public function update(Request $request, \App\Models\Payment $payment)
    {
        $validated = $request->validate([
            'gaming_session_id' => 'sometimes|required|exists:gaming_sessions,id',
            'nominal' => 'sometimes|numeric|min:0',
            'method' => 'sometimes|required|in:cash,qris,transfer,member',
        ]);


        $payment->update($validated);

        return response()->json(['message' => 'Payment berhasil diperbarui', 'data' => $payment]);
    }

    public function destroy(\App\Models\Payment $payment)
    {
        $payment->delete();
        return response()->json(['message' => 'Payment berhasil dihapus']);
    }
}

