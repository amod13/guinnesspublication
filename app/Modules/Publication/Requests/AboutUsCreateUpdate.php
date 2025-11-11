<?php

namespace App\Modules\Publication\Requests;

use App\Core\Request\BaseFormRequest;
use Illuminate\Validation\Rule;

class AboutUsCreateUpdate extends BaseFormRequest
{
    protected function getCreateRules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'slug' => 'nullable|unique:about_us,slug',
            'description' => 'nullable|string',
            'image_media_id' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_media_id_media_id' => 'nullable|integer|exists:media_library,id',
            'status' => 'nullable|in:active,inactive',
            'features' => 'nullable|array',
            'features.feature_items' => 'nullable|array',
            'features.feature_items.*.title' => 'nullable|string|max:255',
            'features.feature_items.*.icon' => 'nullable|string|max:100',
            'features.checklist' => 'nullable|array',
            'features.checklist.*' => 'nullable|string|max:255',
            'years_of_experience' => 'nullable|string|max:50',
            'happy_clients' => 'nullable|string|max:50',
            'display_order' => 'nullable|integer|min:1',
            'language_id' => 'nullable|integer|in:1,2',
        ];
    }

    protected function getUpdateRules(): array
    {
        $dataId = $this->getRouteId();

        return [
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'slug' => [
                'nullable',
                Rule::unique('about_us', 'slug')->ignore($dataId),
            ],
            'description' => 'nullable|string',
            'image_media_id' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_media_id_media_id' => 'nullable|integer|exists:media_library,id',
            'status' => 'nullable|in:active,inactive',
            'features' => 'nullable|array',
            'features.feature_items' => 'nullable|array',
            'features.feature_items.*.title' => 'nullable|string|max:255',
            'features.feature_items.*.icon' => 'nullable|string|max:100',
            'features.checklist' => 'nullable|array',
            'features.checklist.*' => 'nullable|string|max:255',
            'years_of_experience' => 'nullable|string|max:50',
            'happy_clients' => 'nullable|string|max:50',
            'display_order' => 'nullable|integer|min:1',
            'language_id' => 'nullable|integer|in:1,2',
        ];
    }

}
