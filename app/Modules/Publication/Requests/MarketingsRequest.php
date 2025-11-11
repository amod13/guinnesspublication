<?php

namespace App\Modules\Publication\Requests;

use App\Core\Request\BaseFormRequest;

class MarketingsRequest extends BaseFormRequest
{
    protected function getCreateRules(): array
    {
        return [
            'school_name' => ['required', 'string', 'max:255'],
            'school_address' => ['required', 'string', 'max:255'],
            'school_email' => ['required', 'email', 'unique:marketings,school_email'],
            'school_phone' => ['nullable', 'string', 'max:15'],
            'visit_date' => ['required', 'date', 'before_or_equal:today'],
            'remarks' => ['nullable', 'string'],
            'status' => ['nullable', 'in:active,inactive'],
            'display_order' => ['nullable', 'integer', 'min:1'],
        ];
    }

    protected function getUpdateRules(): array
    {
        return [
            'school_name' => ['required', 'string', 'max:255'],
            'school_address' => ['required', 'string', 'max:255'],
            'school_email' => [
                'required',
                'email',
                'unique:marketings,school_email,' . $this->route('id'),
            ],
            'school_phone' => ['nullable', 'string', 'max:15'],
            'visit_date' => ['required', 'date', 'before_or_equal:today'],
            'remarks' => ['nullable', 'string'],
            'status' => ['required', 'in:active,inactive'],
            'display_order' => ['nullable', 'integer', 'min:1'],
        ];
    }

    protected function getMessages(): array
    {
        return [
            'school_name.required' => 'School name is required.',
            'school_address.required' => 'School address is required.',
            'school_email.required' => 'School email is required.',
            'school_email.email' => 'Please enter a valid email address.',
            'school_email.unique' => 'This school email is already taken.',
            'status.in' => 'Status must be either active or inactive.',
        ];
    }
}
