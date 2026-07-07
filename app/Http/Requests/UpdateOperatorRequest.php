<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOperatorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'sometimes|required|exists:users,id',
            'shift' => 'sometimes|nullable|string|max:30',
            'room_id' => 'sometimes|nullable|exists:rooms,id',
        ];
    }
}
