<?php

namespace App\Modules\Publication\Requests;

use App\Core\Request\BaseFormRequest;

class StoreContactMessageRequest extends BaseFormRequest
{
    protected function getCreateRules(): array
    {
        return [
            'full_name' => 'required|string',
            'contact_email' => 'required|email:unique:contact_messages,contact_email',
            'subject' => 'required|string',
            'message' => 'required|string',
        ];
    }
}
