<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMembershipRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'level' => 'sometimes|required|string|max:50',
            'discount_percent' => 'sometimes|nullable|numeric|min:0|max:100',
            'tag' => 'sometimes|nullable|string|max:50',
        ];
    }
}
