<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // You can add user permission checks here if needed
    }

    public function rules(): array
    {
        return [
            'dark_mode' => ['required', 'boolean'],
            'language'  => ['required', 'in:en,id,fr'], // Add more languages as needed
            'is_admin'  => ['sometimes', 'boolean'],    // Optional, for admin-only access
        ];
    }

    public function messages(): array
    {
        return [
            'dark_mode.required' => 'Please specify if dark mode is enabled.',
            'language.in'        => 'The selected language is not supported.',
        ];
    }
}
