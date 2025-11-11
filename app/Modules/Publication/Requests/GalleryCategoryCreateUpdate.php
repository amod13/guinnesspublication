<?php

namespace App\Modules\Publication\Requests;

use App\Core\Request\BaseFormRequest;
use Illuminate\Validation\Rule;

class GalleryCategoryCreateUpdate extends BaseFormRequest
{
    protected $tempImageFields = ['thumbnail_image_id'];

    protected function getCreateRules(): array
    {
        return [
            'title' => [
                'required',
            ],
            'description' => 'nullable',
            'slug' => [
                'nullable',
                'unique:gallery_categories,slug',
            ],
            'status' => 'nullable|in:0,1',
            'display_order' => 'nullable|integer|min:1',
            'thumbnail_image_id' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'thumbnail_image_id_media_id' => 'nullable|integer',
        ];
    }

    protected function getUpdateRules(): array
    {
        $dataId = $this->getRouteId();

        return [
            'title' => [
                'required',
            ],
            'description' => 'nullable',
            'slug' => [
                'nullable',
                Rule::unique('gallery_categories', 'slug')->ignore($dataId),
            ],
            'display_order' => 'nullable',
            'status' => 'nullable|in:0,1',
            'thumbnail_image_id' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                        'thumbnail_image_id_media_id' => 'nullable|integer',
        ];
    }
}
