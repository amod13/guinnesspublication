<?php

namespace App\Modules\Publication\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthorCreateUpdate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'status' => 'nullable|in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_media_id' => 'nullable|integer',
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Author name is required.',
            'username.required' => 'Username is required when creating user account.',
            'user_email.required' => 'User email is required when creating user account.',
        ];
    }
}
