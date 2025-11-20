<?php

namespace App\Modules\Publication\Requests;

use App\Core\Request\BaseFormRequest;

class BlogCategoryCreateUpdate extends BaseFormRequest
{
    protected $tempImageFields = ['thumbnail_image'];
    public function getCreateRules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blog_categories,slug',
            'thumbnail_image' => 'nullable|string',
                        'thumbnail_image_media_id' => 'nullable|integer',
            'display_order' => 'nullable|integer|min:1',
            'status' => 'nullable|in:0,1',
            'parent_id' => 'nullable|exists:blog_categories,id',
        ];
    }

    public function getUpdateRules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blog_categories,slug,' . $this->route('id'),
            'thumbnail_image' => 'nullable|string',
                                    'thumbnail_image_media_id' => 'nullable|integer',
            'display_order' => 'nullable|integer|min:1',
            'status' => 'required|boolean',
            'parent_id' => 'nullable|exists:blog_categories,id',
        ];
    }
}
