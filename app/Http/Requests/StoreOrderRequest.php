<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'service_id' => 'required|exists:services,id',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'required|email',
            'alamat_lengkap' => 'required|string',
            'catatan_customer' => 'nullable|string|max:1000',
            'total_harga' => 'required|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'service_id.required' => 'Pilih layanan terlebih dahulu.',
            'service_id.exists' => 'Layanan tidak ditemukan.',
        ];
    }
}
