<?php

namespace App\Modules\Publication\Requests;

use App\Core\Request\BaseFormRequest;
use Illuminate\Validation\Rule;

class VMGCreateUpdateRequest extends BaseFormRequest
{
    protected function getCreateRules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'slug' => 'nullable|unique:vmgs,slug',
            'video_url' => 'nullable|url',
            'front_image_id' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'front_image_id_media_id' => 'nullable|integer|exists:media_library,id',
            'back_image_id' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'back_image_id_media_id' => 'nullable|integer|exists:media_library,id',
            'status' => 'nullable|in:0,1',
            'features' => 'nullable|array',
            'features.features' => 'nullable|array',
            'features.features.*' => 'nullable|string|max:255',
            'display_order' => 'nullable|integer|min:1',
        ];
    }

    protected function getUpdateRules(): array
    {
        $dataId = $this->getRouteId();

        return [
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'slug' => [
                'nullable',
                Rule::unique('vmgs', 'slug')->ignore($dataId),
            ],
            'video_url' => 'nullable|url',
            'front_image_id' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'front_image_id_media_id' => 'nullable|integer|exists:media_library,id',
            'back_image_id' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'back_image_id_media_id' => 'nullable|integer|exists:media_library,id',
            'status' => 'nullable|in:0,1',
            'features' => 'nullable|array',
            'features.features' => 'nullable|array',
            'features.features.*' => 'nullable|string|max:255',
            'display_order' => 'nullable|integer|min:1',
        ];
    }
}
