<?php

namespace App\Modules\Publication\Repositories\Implementations;

use App\Core\Repositories\Implementation\BaseRepository;
use App\Modules\Publication\Models\Blog;
use App\Modules\Publication\Repositories\Interfaces\BlogRepositoryInterface;
use Illuminate\Support\Facades\DB;

class BlogRepository extends BaseRepository implements BlogRepositoryInterface
{
    public function __construct(Blog $model)
    {
        parent::__construct($model);
    }

    public function getPublishedBlogs()
    {
        return $this->model
            ->select([
                'id',
                'blog_category_id',
                'title',
                'content',
                'slug',
                'excerpt',
                'thumbnail_image',
                'author_name',
                'published_date',
            ])
            ->with([
                'blogCategory:id,title,slug' // only category id and name
            ])
            ->where('is_published', true)
            ->where('status', true)
            ->orderBy('display_order')
            ->get();
    }

    public function getBlogBySlug($slug)
    {
        $blog = $this->model
            ->select([
                'id',
                'blog_category_id',
                'title',
                'content',
                'slug',
                'excerpt',
                'thumbnail_image',
                'author_name',
                'published_date',
            ])
            ->with([
                'blogCategory:id,title,slug',
            ])
            ->where('slug', $slug)
            ->where('is_published', true)
            ->where('status', true)
            ->first();

        if ($blog) {
            $relatedBlogs = $this->model
                ->select([
                    'id',
                    'title',
                    'slug',
                    'thumbnail_image',
                    'published_date',
                ])
                ->where('blog_category_id', $blog->blog_category_id)
                ->where('id', '!=', $blog->id)
                ->where('is_published', true)
                ->where('status', true)
                ->latest('published_date')
                ->take(3) // limit 3 related blogs
                ->get();

            // attach related blogs as dynamic property
            $blog->related_blogs = $relatedBlogs;
        }

        return $blog;
    }


    public function getBlogByCategorySlug($slug)
    {
        $categoryId = DB::table('blog_categories')->where('slug', $slug)->value('id');
        return $this->model
            ->select([
                'id',
                'blog_category_id',
                'title',
                'content',
                'slug',
                'excerpt',
                'thumbnail_image',
                'author_name',
                'published_date',
            ])
            ->with([
                'blogCategory:id,title' // only category id and name
            ])
            ->where('blog_category_id', $categoryId)
            ->where('is_published', true)
            ->where('status', true)
            ->paginate(10);
    }

}
