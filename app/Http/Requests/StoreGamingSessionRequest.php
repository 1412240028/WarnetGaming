<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGamingSessionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'room_id' => 'required|exists:rooms,id',
            'pc_id' => 'required|exists:pcs,id',
            'operator_id' => 'required|exists:operators,id',
            'started_at' => 'nullable|date',
        ];
    }
}
