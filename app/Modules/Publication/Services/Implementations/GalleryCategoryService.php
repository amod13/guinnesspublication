<?php

namespace App\Modules\Publication\Services\Implementations;

use App\Core\Services\Implementation\BaseService;
use App\Core\Traits\HasPaginatedSearch;
use App\Core\Utils\SlugGeneratorService;
use App\Modules\Publication\DTOs\GalleryCategory\GalleryCategoryDto;
use App\Modules\Publication\Repositories\Interfaces\GalleryCategoryRepositoryInterface;
use App\Modules\Publication\Services\Interfaces\GalleryCategoryServiceInterface;

class GalleryCategoryService extends BaseService implements GalleryCategoryServiceInterface
{
    use HasPaginatedSearch;

    public function __construct(GalleryCategoryRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function getPaginatedSearchResults(int $perPage, ?string $search = null)
    {
        $filters = ['search' => $search];
        return $this->hasPaginatedWithSearch(
            perPage: $perPage,
            filters: $filters,
            searchableFields: ['title', 'description'],
            dtoClass: GalleryCategoryDto::class,
            useFromCollection: false,
            sortDir: 'asc',
            sortBy: 'display_order',
            baseQuery: null
        );
    }

    public function createRecord($data)
    {
        if (isset($data['thumbnail_image_id_media_id']) && $data['thumbnail_image_id_media_id']) {
            $data['thumbnail_image_id'] = $data['thumbnail_image_id_media_id'];
        }

        $data['slug'] = SlugGeneratorService::generateSlug('gallery_categories', $data['title']);

        return $this->repository->createRecord($data);
    }

    public function updateRecord($data, $id)
    {
        if (isset($data['thumbnail_image_id_media_id']) && $data['thumbnail_image_id_media_id']) {
            $data['thumbnail_image_id'] = $data['thumbnail_image_id_media_id'];
        }

        $data['slug'] = $data['slug'] ?? SlugGeneratorService::generateSlug('gallery_categories', $data['title']);

        return $this->repository->updateRecord($id, $data);
    }

    public function getActiveGalleryCategories()
    {
        return $this->repository->getActiveGalleryCategories();
    }
}
