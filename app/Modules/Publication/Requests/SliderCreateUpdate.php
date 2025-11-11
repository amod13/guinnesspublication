<?php

namespace App\Modules\Publication\Requests;


use App\Core\Request\BaseFormRequest;
use Illuminate\Validation\Rule;

class SliderCreateUpdate extends BaseFormRequest
{
    protected $tempImageFields = ['background_image'];

    protected function getCreateRules(): array
    {
        return [
            'title' => [
                'required',
            ],
            'subtitle' => 'nullable',
            'slug' => [
                'nullable',
                'unique:sliders,slug',
            ],
            'description' => 'nullable',
            'status' => 'nullable|in:0,1',
            'display_order' => 'nullable|integer|min:1',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'background_image_media_id' => 'nullable|integer',
            'background_image_1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'background_image_1_media_id' => 'nullable|integer',
            'background_image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'background_image_2_media_id' => 'nullable|integer',
        ];
    }

    protected function getUpdateRules(): array
    {
        $dataId = $this->getRouteId();

        return [
            'title' => [
                'required',
            ],
            'subtitle' => 'nullable',
            'description' => 'nullable',
            'slug' => [
                'nullable',
                Rule::unique('sliders', 'name')->ignore($dataId),
            ],
            'display_order' => 'nullable',
            'status' => 'nullable|in:0,1',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'background_image_media_id' => 'nullable|integer',
            'background_image_1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'background_image_1_media_id' => 'nullable|integer',
            'background_image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'background_image_2_media_id' => 'nullable|integer',
        ];
    }
}
