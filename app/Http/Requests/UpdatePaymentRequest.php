<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'gaming_session_id' => 'sometimes|required|exists:gaming_sessions,id',
            'nominal' => 'sometimes|numeric|min:0',
            'method' => 'sometimes|required|in:cash,qris,transfer,member',
        ];
    }
}
