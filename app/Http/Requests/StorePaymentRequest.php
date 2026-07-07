<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'gaming_session_id' => 'required|exists:gaming_sessions,id',
            'nominal' => 'required|numeric|min:0',
            'method' => 'required|in:cash,qris,transfer,member',
        ];
    }
}
