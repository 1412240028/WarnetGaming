<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePcRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => 'sometimes|required|string|max:20',
            'status' => 'sometimes|nullable|string|max:50',
            'room_id' => 'sometimes|nullable|exists:rooms,id',
        ];
    }
}
