<?php

namespace App\Modules\Publication\Requests;

use App\Core\Request\BaseFormRequest;

class AuthorsRequest extends BaseFormRequest
{
    protected function getCreateRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'unique:authors,email'],
            'address' => ['nullable', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'status' => ['nullable', 'in:active,inactive'],
            'display_order' => ['nullable', 'integer', 'min:1'],
        ];
    }

    protected function getUpdateRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'unique:authors,email,' . $this->route('id')],
            'address' => ['nullable', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
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