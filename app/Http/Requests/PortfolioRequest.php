<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PortfolioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kategori' => 'required|string|max:100',
            'tanggal_project' => 'nullable|date',
            'client_name' => 'nullable|string|max:100',
            'lokasi' => 'nullable|string|max:100',
            'nilai_project' => 'nullable|numeric',
            'durasi_hari' => 'nullable|integer',
            'foto_cover' => 'nullable|image|max:4096',
        ];
    }
}
