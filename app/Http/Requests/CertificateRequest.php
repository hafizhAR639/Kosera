<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CertificateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'issued_by' => 'required|string|max:255',
            'issued_date' => 'required|date',
            'expiry_date' => 'nullable|date',
            'certificate_number' => 'nullable|string|max:100',
            'category' => 'required|in:teknis,keselamatan,manajemen,lainnya',
        ];
    }
}
