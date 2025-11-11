<?php

namespace App\Modules\Publication\Services\Implementations;

use App\Core\Services\Implementation\BaseService;
use App\Core\Traits\HasPaginatedSearch;
use App\Core\Utils\SlugGeneratorService;
use App\Modules\Publication\DTOs\Slider\SliderDto;
use App\Modules\Publication\Repositories\Interfaces\SliderRepositoryInterface;
use App\Modules\Publication\Services\Interfaces\SliderServiceInterface;

class SliderService extends BaseService implements SliderServiceInterface
{
    use HasPaginatedSearch;
    public function __construct(SliderRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
    public function getPaginatedSearchResults(int $perPage, ?string $search = null)
    {
        $filters = ['search' => $search];
        return $this->hasPaginatedWithSearch(
            perPage: $perPage,
            filters: $filters,
            searchableFields: ['title', 'subtitle'],
            dtoClass: SliderDto::class,
            useFromCollection: false,
            sortDir: 'asc',
            sortBy: 'display_order',
            baseQuery: null,
            filterField: 'language',
            filterId: session('language', 'en')
        );
    }
    public function createRecord($data)
    {
        // Handle media ID for featured image
        if (isset($data['background_image_media_id']) && $data['background_image_media_id']) {
            $data['background_image'] = $data['background_image_media_id'];
        }
        if (isset($data['background_image_1_media_id']) && $data['background_image_1_media_id']) {
            $data['background_image_1'] = $data['background_image_1_media_id'];
        }
        if (isset($data['background_image_2_media_id']) && $data['background_image_2_media_id']) {
            $data['background_image_2'] = $data['background_image_2_media_id'];
        }

        // Generate slug based on title
        $data['language'] = session('language', 'en');
        $data['slug'] = SlugGeneratorService::generateSlug('sliders', $data['title']);

        return $this->repository->createRecord($data);
    }


    public function updateRecord($data, $id)
    {
        // Handle media ID for featured image
        if (isset($data['background_image_media_id']) && $data['background_image_media_id']) {
            $data['background_image'] = $data['background_image_media_id'];
        }
       if (isset($data['background_image_1_media_id']) && $data['background_image_1_media_id']) {
            $data['background_image_1'] = $data['background_image_1_media_id'];
        }
        if (isset($data['background_image_2_media_id']) && $data['background_image_2_media_id']) {
            $data['background_image_2'] = $data['background_image_2_media_id'];
        }

        $data['language'] = session('language', 'en');

        $data['slug'] = SlugGeneratorService::generateSlug('sliders', $data['title']);

        return $this->repository->updateRecord($id, $data);
    }

    public function getActiveSliders()
    {
        return $this->repository->getActiveSliders();
    }

}
