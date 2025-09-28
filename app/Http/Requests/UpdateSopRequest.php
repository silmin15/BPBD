<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSopRequest extends FormRequest
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
            'file'  => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'is_published' => ['nullable', 'boolean'],
        ];
    }
}
