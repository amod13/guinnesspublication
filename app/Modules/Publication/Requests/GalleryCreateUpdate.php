<?php

namespace App\Modules\Publication\Requests;

use App\Core\Request\BaseFormRequest;

class GalleryCreateUpdate extends BaseFormRequest
{
protected function getCreateRules(): array
{
    return [
        'category_id' => 'required|exists:gallery_categories,id',
        'file_type' => 'required|in:image,video',

        // Images validation only if file_type is 'image'
        'images' => 'nullable|array|required_if:file_type,image',
        'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5024|required_if:file_type,image',
        'captions' => 'nullable|array',
        'captions.*' => 'nullable|string',

        // Video validation only if file_type is 'video'
        'video_urls' => 'nullable|array|required_if:file_type,video',
        'video_urls.*' => 'url|required_if:file_type,video',
        'video_captions' => 'nullable|array',
        'video_captions.*' => 'nullable|string',
    ];
}


protected function getUpdateRules(): array
{
    return [
        'category_id' => 'required|exists:gallery_categories,id',
        'file_type' => 'required|in:image,video',

        'images' => 'nullable|array|required_if:file_type,image',
        'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5024|required_if:file_type,image',
        'captions.*' => 'nullable|string',

        'video_urls' => 'nullable|array|required_if:file_type,video',
        'video_urls.*' => 'url|required_if:file_type,video',
        'video_captions.*' => 'nullable|string',
    ];
}

}
