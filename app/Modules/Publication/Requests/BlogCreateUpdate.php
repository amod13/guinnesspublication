<?php

namespace App\Modules\Publication\Requests;

use App\Core\Request\BaseFormRequest;

class BlogCreateUpdate extends BaseFormRequest
{
    public function getCreateRules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blogs,slug',
            'excerpt' => 'nullable|string',
            'content' => 'nullable|string',
            'blog_category_id' => 'nullable|exists:blog_categories,id',
            'featured_image' => 'nullable|string',
            'thumbnail_image' => 'nullable|string',
            'thumbnail_image_media_id' => 'nullable|integer',
            'video_url' => 'nullable|url',
            'author_name' => 'nullable|string|max:255',
            'published_date' => 'nullable|date',
            'is_published' => 'required|boolean',
            'display_order' => 'nullable|integer|min:1',
            'status' => 'nullable|boolean',
            'tags.*' => 'nullable|string',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
        ];
    }

    public function getUpdateRules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blogs,slug,' . $this->route('id'),
            'excerpt' => 'nullable|string',
            'content' => 'nullable|string',
            'blog_category_id' => 'nullable|exists:blog_categories,id',
            'featured_image' => 'nullable|string',
            'thumbnail_image' => 'nullable|string',
            'thumbnail_image_media_id' => 'nullable|integer',
            'video_url' => 'nullable|url',
            'author_name' => 'nullable|string|max:255',
            'published_date' => 'nullable|date',
            'is_published' => 'required|boolean',
            'display_order' => 'nullable|integer|min:1',
            'status' => 'nullable|boolean',
            'tags.*' => 'nullable|string',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string|max:255',
        ];
    }
}
