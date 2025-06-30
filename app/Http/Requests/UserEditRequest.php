<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserEditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . Auth::id()],
            'new_password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'current_password' => ['required_with:new_password'],
            'new_password_confirmation' => ['required_with:new_password', 'same:new_password'],
        ];
    }

    /**
     * Custom error messages for validation.
     */
    public function messages()
    {
        return [
            'name.required' => 'Your name is required.',
            'email.required' => 'We need your email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already taken.',
            'new_password.min' => 'New password must be at least 8 characters.',
            'new_password.confirmed' => 'New password does not match with your old password.',
            'current_password.required_with' => 'Please enter your current password to change your password.',
            'new_password_confirmation.required_with' => 'Please confirm your new password.',
            'new_password_confirmation.same' => 'New password confirmation must match the new password.',
        ];
    }
}
