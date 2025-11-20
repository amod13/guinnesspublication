<?php

namespace App\Modules\Publication\Services\Implementations;

use App\Core\Services\Implementation\BaseService;
use App\Core\Traits\HasPaginatedSearch;
use App\Core\Utils\SlugGeneratorService;
use App\Modules\Publication\DTOs\Blog\BlogDto;
use App\Modules\Publication\Helpers\SeoHelper;
use App\Modules\Publication\Repositories\Interfaces\BlogRepositoryInterface;
use App\Modules\Publication\Services\Interfaces\BlogServiceInterface;

class BlogService extends BaseService implements BlogServiceInterface
{
    use HasPaginatedSearch;
    protected string $dtoClass = BlogDto::class;

    public function __construct(BlogRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function getPaginatedSearchResults(int $perPage, ?string $search = null)
    {
        $filters = ['search' => $search];
        return $this->hasPaginatedWithSearch(
            perPage: $perPage,
            filters: $filters,
            searchableFields: ['title'],
            dtoClass: BlogDto::class,
            useFromCollection: false,
            sortDir: 'asc',
            sortBy: 'display_order',
            baseQuery: null,
            filterField: 'language',
            filterId: session('language', 'en')
        );
    }

    public function getPublishedBlogs()
    {
        return $this->repository->getPublishedBlogs();
    }

    public function createRecord($data)
    {
        if (empty($data['slug'])) {
            $data['slug'] = SlugGeneratorService::generateSlug('blogs', $data['title']);
        }

        // Process tags - ensure array format
        if (!isset($data['tags']) || !is_array($data['tags'])) {
            $data['tags'] = [];
        }

        // Auto-generate SEO fields if empty
        if (empty($data['meta_title'])) {
            $data['meta_title'] = SeoHelper::generateMetaTitle($data['title']);
        }

        if (empty($data['meta_description'])) {
            $data['meta_description'] = SeoHelper::generateMetaDescription($data['title'], $data['excerpt'] ?? null);
        }

        if (empty($data['meta_keywords'])) {
            $data['meta_keywords'] = SeoHelper::generateMetaKeywords($data['title'], $data['tags'] ?? null);
        }

        if (isset($data['featured_image']) && !empty($data['featured_image_media_id'])) {
            $data['featured_image'] = $data['featured_image_media_id'];
        }

        if (isset($data['thumbnail_image_media_id']) && !empty($data['thumbnail_image_media_id'])) {
            $data['thumbnail_image'] = $data['thumbnail_image_media_id'];
        }
        $data['language'] = session('language', 'en');
        return $this->repository->createRecord($data);
    }

    public function updateRecord($data, $id)
    {
        if (empty($data['slug'])) {
            $data['slug'] = SlugGeneratorService::generateSlug('blogs', $data['title']);
        }

        // Process tags - ensure array format
        if (!isset($data['tags']) || !is_array($data['tags'])) {
            $data['tags'] = [];
        }

        // Auto-generate SEO fields if empty
        if (empty($data['meta_title'])) {
            $data['meta_title'] = SeoHelper::generateMetaTitle($data['title']);
        }

        if (empty($data['meta_description'])) {
            $data['meta_description'] = SeoHelper::generateMetaDescription($data['title'], $data['excerpt'] ?? null);
        }

        if (empty($data['meta_keywords'])) {
            $data['meta_keywords'] = SeoHelper::generateMetaKeywords($data['title'], $data['tags'] ?? null);
        }

        if (isset($data['featured_image_media_id']) && !empty($data['featured_image_media_id'])) {
            $data['featured_image'] = $data['featured_image_media_id'];
        }

        if (isset($data['thumbnail_image_media_id']) && !empty($data['thumbnail_image_media_id'])) {
            $data['thumbnail_image'] = $data['thumbnail_image_media_id'];
        }
        $data['language'] = session('language', 'en');
        return $this->repository->updateRecord($id, $data);
    }

    public function getBlogBySlug($slug)
    {
        return $this->repository->getBlogBySlug($slug);
    }
    public function getBlogByCategorySlug($slug)
    {
        return $this->repository->getBlogByCategorySlug($slug);
    }
}
