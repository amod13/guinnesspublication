<?php

namespace App\Modules\Publication\Models;

use App\Core\Traits\HasMediaLibrary;
use App\Modules\UserManagement\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory, HasMediaLibrary;
    protected $fillable = [
        'blog_category_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'tags',
        'featured_image',
        'thumbnail_image',
        'video_url',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'meta_og_image',
        'author_id',
        'author_name',
        'published_date',
        'is_published',
        'views_count',
        'display_order',
        'status',
        'language',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'tags' => 'array',
        'is_published' => 'boolean',
        'status' => 'boolean',
        'views_count' => 'integer',
        'display_order' => 'integer',
        'published_date' => 'date',
    ];

    public function blogCategory()
    {
        return $this->belongsTo(BlogCategory::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
