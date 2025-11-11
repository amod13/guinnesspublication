<?php

namespace App\Modules\Publication\Services\Implementations;

use App\Core\Services\Implementation\BaseService;
use App\Modules\Publication\DTOs\BookCategories\BookCategoriesDto;
use App\Core\Utils\SlugGeneratorService;
use App\Core\Traits\HasPaginatedSearch;
use App\Modules\Publication\Services\Interfaces\BookCategoriesServiceInterface;
use App\Modules\Publication\Repositories\Interfaces\BookCategoriesRepositoryInterface;

class BookCategoriesService extends BaseService implements BookCategoriesServiceInterface
{
    use HasPaginatedSearch;
    public function __construct(BookCategoriesRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
    public function createRecord($data)
    {
        $data['slug'] = SlugGeneratorService::generateSlug('book_categories', $data['name']);

        $data['language'] = session('language', 'en');
        // Handle media ID
        if (!empty($data['thumbnail_image_media_id'])) {
            $data['thumbnail_image'] = $data['thumbnail_image_media_id'];
        }

        return $this->repository->createRecord($data);
    }

    public function updateRecord($data, $id)
    {
        if (isset($data['name'])) {
            $data['slug'] = SlugGeneratorService::generateSlug('book_categories', $data['name'], 'slug');
        }

        // Handle media ID
        if (!empty($data['thumbnail_image_media_id'])) {
            $data['thumbnail_image'] = $data['thumbnail_image_media_id'];
        }

        $data['language'] = session('language', 'en');

        return $this->repository->updateRecord($id, $data);
    }

    public function getPaginatedSearchResults(int $perPage, ?string $search = null)
    {
        $filters = ['search' => $search];
        return $this->hasPaginatedWithSearch(
            perPage: $perPage,
            filters: $filters,
            searchableFields: ['name'],
            dtoClass: BookCategoriesDto::class,
            useFromCollection: false,
            sortDir: 'asc',
            sortBy: 'display_order',
            baseQuery: null,
            filterField: 'language',
            filterId: session('language', 'en')
        );
    }

    public function getActiveBookCategories()
    {
        return $this->repository->getActiveBookCategories();
    }
}
