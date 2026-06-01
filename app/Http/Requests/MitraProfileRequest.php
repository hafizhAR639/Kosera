<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MitraProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:255',
            'phone' => 'nullable|string|max:30',
            'location' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'avatar' => 'nullable|image|max:4096',
            'nama_bank' => 'nullable|string|max:100',
            'nama_rekening' => 'nullable|string|max:100|required_with:nama_bank,nomor_rekening',
            'nomor_rekening' => 'nullable|string|max:50|required_with:nama_bank,nama_rekening',
            'alamat_bank' => 'nullable|string|max:255',
        ];
    }
}
