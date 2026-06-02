<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_layanan' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'harga_mulai' => 'nullable|numeric',
            'harga_max' => 'nullable|numeric',
            'satuan' => 'nullable|string|max:50',
            'durasi_estimasi' => 'nullable|string|max:100',
            'area_layanan' => 'nullable|string',
            'foto' => 'nullable|image|min:50|max:4096',
            'foto_cover' => 'nullable|image|min:50|max:4096',
            'status' => 'nullable|in:active,inactive',
        ];
    }

    public function messages(): array
    {
        return [
            'foto.min' => 'Ukuran foto minimal 50 KB',
            'foto.max' => 'Ukuran foto maksimal 4 MB',
            'foto_cover.min' => 'Ukuran foto cover minimal 50 KB',
            'foto_cover.max' => 'Ukuran foto cover maksimal 4 MB',
        ];
    }
}
