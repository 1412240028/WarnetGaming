<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Payment::query();

        if ($request->filled('method')) {
            $query->where('method', $request->string('method'));
        }


        return \App\Http\Resources\PaymentResource::collection($query->paginate(10));
    }

    public function store(StorePaymentRequest $request)
    {
        $validated = $request->validated();


        $payment = \App\Models\Payment::create($validated);

        return (new \App\Http\Resources\PaymentResource($payment))->additional(['message' => 'Payment berhasil dibuat'])->response()->setStatusCode(201);
    }

    public function show(\App\Models\Payment $payment)
    {
        return new \App\Http\Resources\PaymentResource($payment);
    }

    public function update(UpdatePaymentRequest $request, \App\Models\Payment $payment)
    {
        $validated = $request->validated();


        $payment->update($validated);

        return (new \App\Http\Resources\PaymentResource($payment))->additional(['message' => 'Payment berhasil diperbarui']);
    }

    public function destroy(\App\Models\Payment $payment)
    {
        $payment->delete();
        return response()->json(['message' => 'Payment berhasil dihapus']);
    }
}

