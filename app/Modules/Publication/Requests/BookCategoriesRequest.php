<?php

namespace App\Modules\Publication\Requests;

use App\Core\Request\BaseFormRequest;

class BookCategoriesRequest extends BaseFormRequest
{
    protected function getCreateRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'status' => ['nullable', 'in:active,inactive'],
            'display_order' => ['nullable', 'integer', 'min:1'],
            'thumbnail_image_media_id' => ['nullable', 'exists:media_library,id'],
        ];
    }

    protected function getUpdateRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:active,inactive'],
            'display_order' => ['nullable', 'integer', 'min:1'],
            'thumbnail_image_media_id' => ['nullable', 'exists:media_library,id'],
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
            'thumbnail_image_media_id.exists' => 'The thumbnail image media id does not exist.',
        ];
    }
}
