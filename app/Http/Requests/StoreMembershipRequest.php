<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMembershipRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'level' => 'required|string|max:50',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'tag' => 'nullable|string|max:50',
        ];
    }
}
