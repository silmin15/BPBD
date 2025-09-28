<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSopRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nomor' => ['required', 'string', 'max:100'],
            'judul' => ['required', 'string', 'max:255'],
            'file'  => ['required', 'file', 'mimes:pdf', 'max:10240'], // 10MB
            'is_published' => ['nullable', 'boolean'],
        ];
    }
}
