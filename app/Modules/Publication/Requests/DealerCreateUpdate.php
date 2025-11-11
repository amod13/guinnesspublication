<?php

namespace App\Modules\Publication\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class DealerCreateUpdate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'required|string|max:500',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'status' => 'nullable|in:active,inactive',
            'create_user' => 'nullable|boolean',
        ];

        // Add user validation rules if create_user is checked
        if ($this->input('create_user')) {
            $rules = array_merge($rules, [
                'username' => 'required|string|max:255',
                'user_email' => 'required|email|max:255',
                'password' => 'nullable|string|min:6|confirmed',
                'password_confirmation' => 'nullable|string|min:6',
                'user_status' => 'nullable|in:active,inactive',
            ]);
        }

        return $rules;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->input('create_user')) {
                $isEdit = $this->route('dealer') ? true : false;
                $userExists = false;
                
                if ($isEdit && $this->input('user_email')) {
                    $userExists = DB::table('users')->where('email', $this->input('user_email'))->exists();
                }
                
                // For new users (create mode or edit mode without existing user), password is required
                // if (!$isEdit || !$userExists) {
                //     if (empty($this->input('password'))) {
                //         $validator->errors()->add('password', 'Password is required when creating user account.');
                //     }
                //     if (empty($this->input('password_confirmation'))) {
                //         $validator->errors()->add('password_confirmation', 'The password confirmation field is required.');
                //     }
                // }
            }
        });
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Dealer name is required.',
            'address.required' => 'Address is required.',
            'username.required' => 'Username is required when creating user account.',
            'username.unique' => 'This username is already taken.',
            'user_email.required' => 'User email is required when creating user account.',
            'user_email.unique' => 'This email is already registered.',
            'password.min' => 'Password must be at least 6 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
        ];
    }
}