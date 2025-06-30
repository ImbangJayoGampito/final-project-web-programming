<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // You can restrict access based on user roles here
    }

    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'max:255'],
            'content'     => ['required', 'string'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['string', 'max:50'],

        ];
    }
    public function messages(): array
    {
        return [
            'title.required'       => 'The title is required.',
            'content.required'     => 'The content is required.',
            'user_id.required'     => 'The user ID is required.',
            'category_id.required' => 'The category ID is required.',
            'tags.array'           => 'Tags must be an array.',
            'tags.*.string'        => 'Each tag must be a string.',
            'tags.*.exists'        => 'Each tag must exist in the tags table.',
        ];
    }
}
