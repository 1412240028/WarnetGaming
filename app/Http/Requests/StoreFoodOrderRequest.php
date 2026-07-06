<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFoodOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'gaming_session_id' => 'required|exists:gaming_sessions,id',
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'items' => 'required|array|min:1',
            'items.*.food_beverage_id' => 'required|exists:food_beverages,id',
            'items.*.quantity' => 'required|integer|min:1',
        ];
    }
}
