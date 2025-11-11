<?php

namespace App\Modules\Publication\Services\Implementations;

use App\Core\Services\Implementation\BaseService;
use App\Core\Traits\HasPaginatedSearch;
use App\Core\Utils\SlugGeneratorService;
use App\Modules\Publication\DTOs\Page\PageDto;
use App\Modules\Publication\Repositories\Interfaces\PageRepositoryInterface;
use App\Modules\Publication\Services\Interfaces\PageServiceInterface;

class PageService extends BaseService implements PageServiceInterface
{
    use HasPaginatedSearch;

    public function __construct(PageRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function getPaginatedSearchResults(int $perPage, ?string $search = null)
    {
        $filters = ['search' => $search];
        return $this->hasPaginatedWithSearch(
            perPage: $perPage,
            filters: $filters,
            searchableFields: ['title', 'content'],
            dtoClass: PageDto::class,
            useFromCollection: false,
            sortDir: 'asc',
            sortBy: 'display_order',
            baseQuery: $this->repository->getAllWithRelations(),
            filterField: 'language',
            filterId: session('language', 'en')
        );
    }

    public function createRecord($data)
    {
        if (isset($data['thumbnail_image_id_media_id']) && $data['thumbnail_image_id_media_id']) {
            $data['thumbnail_image_id'] = $data['thumbnail_image_id_media_id'];
        }

        $data['language'] = session('language', 'en');
        $data['slug'] = SlugGeneratorService::generateSlug('pages', $data['title']);

        return $this->repository->createRecord($data);
    }

    public function updateRecord($data, $id)
    {
        if (isset($data['thumbnail_image_id_media_id']) && $data['thumbnail_image_id_media_id']) {
            $data['thumbnail_image_id'] = $data['thumbnail_image_id_media_id'];
        }

        $data['language'] = session('language', 'en');
        $data['slug'] = $data['slug'] ?? SlugGeneratorService::generateSlug('pages', $data['title']);

        return $this->repository->updateRecord($id, $data);
    }

    public function getActivePages()
    {
        return $this->repository->getActivePages();
    }

    public function getSinglePageBySlug($slug)
    {
        return $this->repository->getSinglePageBySlug($slug);
    }
}
