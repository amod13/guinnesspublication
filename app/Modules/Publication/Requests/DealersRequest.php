<?php

namespace App\Modules\Publication\Requests;

use App\Core\Request\BaseFormRequest;

class DealersRequest extends BaseFormRequest
{
    protected function getCreateRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:dealers,email'],
            'phone_number' => ['nullable', 'numeric', 'digits_between:5,15'],
            'address' => ['required', 'string', 'max:255'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'in:active,inactive'],
            'display_order' => ['nullable', 'integer', 'min:1'],
        ];
    }

    protected function getUpdateRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:dealers,email,' . $this->route('id')],
            'phone_number' => ['nullable', 'numeric', 'digits_between:5,15'],
            'address' => ['required', 'string', 'max:255'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:active,inactive'],
            'display_order' => ['nullable', 'integer', 'min:1'],
        ];
    }

    protected function getMessages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'status.required' => 'The status field is required.',
            'status.in' => 'The status must be either active or inactive.',
        ];
    }
}