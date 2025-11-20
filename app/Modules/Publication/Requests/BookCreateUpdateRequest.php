<?php

namespace App\Modules\Publication\Requests;

use App\Core\Request\BaseFormRequest;

class BookCreateUpdateRequest extends BaseFormRequest
{
    protected function getCreateRules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:book_categories,id'],
            'status' => ['nullable', 'in:active,inactive'],
            'display_order' => ['nullable', 'integer', 'min:1'],
            'thumbnail_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'pdf_file' => 'nullable|image|mimes:pdf|max:5048',
            'thumbnail_image_media_id' => ['nullable', 'exists:media_library,id'],
            'pdf_file_media_id' => ['nullable', 'exists:media_library,id'],
            'public_pdf_pages' => ['nullable'],
            'highlights' => ['required'],
            'content' => ['nullable'],
            'author_id' => ['nullable', 'exists:authors,id'],
        ];
    }

    protected function getUpdateRules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:book_categories,id'],
            'status' => ['nullable', 'in:active,inactive'],
            'display_order' => ['nullable', 'integer', 'min:1'],
            'thumbnail_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'pdf_file' => 'nullable|image|mimes:pdf|max:5048',
            'thumbnail_image_media_id' => ['nullable', 'exists:media_library,id'],
            'pdf_file_media_id' => ['nullable', 'exists:media_library,id'],
            'public_pdf_pages' => ['nullable'],
            'highlights' => ['required'],
            'content' => ['nullable'],
            'author_id' => ['nullable', 'exists:authors,id'],
        ];
    }

    protected function getMessages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'category_id.required' => 'The category field is required.',
            'category_id.exists' => 'The selected category is invalid.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'status.required' => 'The status field is required.',
            'status.in' => 'The status must be either active or inactive.',
            'display_order.integer' => 'The display order must be an integer.',
            'thumbnail_image_media_id.required' => 'The thumbnail image field is required.',
            'thumbnail_image_media_id.exists' => 'The selected thumbnail image is invalid.',
            'pdf_file_media_id.required' => 'The Pdf File is required..',
            'pdf_file_media_id.exists' => 'The selected pdf file is invalid.',
            'display_order.min' => 'The display order must be at least 1.',
        ];
    }
}
