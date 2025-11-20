<?php

namespace App\Modules\Publication\Services\Implementations;


use App\Core\Services\Implementation\BaseService;
use App\Core\Traits\HasPaginatedSearch;
use App\Core\Utils\SlugGeneratorService;
use App\Modules\Publication\DTOs\BlogCategory\BlogCategoryDto;
use App\Modules\Publication\Repositories\Interfaces\BlogCategoryRepositoryInterface;
use App\Modules\Publication\Services\Interfaces\BlogCategoryServiceInterface;
use Illuminate\Support\Str;

class BlogCategoryService extends BaseService implements BlogCategoryServiceInterface
{
    use HasPaginatedSearch;
    protected string $dtoClass = BlogCategoryDto::class;

    public function __construct(BlogCategoryRepositoryInterface $repository)
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
            dtoClass: BlogCategoryDto::class,
            useFromCollection: false,
            sortDir: 'asc',
            sortBy: 'display_order',
            baseQuery: null,
            filterField: 'language',
            filterId: session('language', 'en')
        );
    }

    public function getActiveBlogCategories()
    {
        return $this->repository->getActiveBlogCategories();
    }

    public function createRecord($data)
    {
        if (empty($data['slug'])) {
            $data['slug'] = SlugGeneratorService::generateSlug('blog_categories', $data['title']);
        }

        $data['language'] = session('language', 'en');
        // Handle media ID for thumbnail image
        if (isset($data['thumbnail_image_media_id']) && $data['thumbnail_image_media_id']) {
            $data['thumbnail_image'] = $data['thumbnail_image_media_id'];
        }

        return $this->repository->createRecord($data);
    }

    public function updateRecord($data, $id)
    {
        if (empty($data['slug'])) {
            $data['slug'] = SlugGeneratorService::generateSlug('blog_categories', $data['title']);
        }
        // Handle media ID for thumbnail image
        if (isset($data['thumbnail_image_media_id']) && $data['thumbnail_image_media_id']) {
            $data['thumbnail_image'] = $data['thumbnail_image_media_id'];
        }
        $data['language'] = session('language', 'en');

        return $this->repository->updateRecord($id, $data);
    }
}
