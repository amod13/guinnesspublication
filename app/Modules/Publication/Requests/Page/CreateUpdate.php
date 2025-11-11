<?php

namespace App\Modules\Publication\Requests\Page;

use App\Core\Request\BaseFormRequest;
use Illuminate\Validation\Rule;

class CreateUpdate extends BaseFormRequest
{
    protected $tempImageFields = ['thumbnail_image_id'];

    protected function getCreateRules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'slug' => 'nullable|unique:pages,slug',
            'status' => 'nullable|in:0,1',
            'display_order' => 'nullable|integer|min:1',
            'thumbnail_image_id' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'thumbnail_image_id_media_id' => 'nullable|integer',
            'meta_data' => 'nullable|array',
            'language_id' => 'nullable|integer|in:1,2',
        ];
    }

    protected function getUpdateRules(): array
    {
        $dataId = $this->getRouteId();

        return [
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'slug' => [
                'nullable',
                Rule::unique('pages', 'slug')->ignore($dataId),
            ],
            'display_order' => 'nullable|integer|min:1',
            'status' => 'nullable|in:0,1',
            'thumbnail_image_id' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'thumbnail_image_id_media_id' => 'nullable|integer',
            'meta_data' => 'nullable|array',
            'language_id' => 'nullable|integer|in:1,2',
        ];
    }
}
