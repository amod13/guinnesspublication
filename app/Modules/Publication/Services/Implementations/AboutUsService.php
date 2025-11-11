<?php

namespace App\Modules\Publication\Services\Implementations;

use App\Core\Services\Implementation\BaseService;
use App\Core\Utils\SlugGeneratorService;
use App\Modules\Publication\DTOs\AboutUs\AboutUsDto;
use App\Modules\Publication\Repositories\Interfaces\AboutUsRepositoryInterface;
use App\Modules\Publication\Services\Interfaces\AboutUsServiceInterface;

class AboutUsService extends BaseService implements AboutUsServiceInterface
{
    public function __construct(AboutUsRepositoryInterface $repository)
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
            dtoClass: AboutUsDto::class,
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
        $data['slug'] = SlugGeneratorService::generateSlug('about_us', $data['title']);

        // Handle media ID
        if (!empty($data['image_media_id_media_id'])) {
            $data['image_media_id'] = $data['image_media_id_media_id'];
        }
        $data['language'] = session('language', 'en');

        // Check if content already exists for this language
        $checkDataExist = $this->hasBaseDataForLanguage($data['language']);

        if ($checkDataExist) {
            return false; // Controller will handle error message
        }

        return $this->repository->createRecord($data);
    }

    public function updateRecord($data, $id)
    {
        $data['language'] = session('language', 'en');
        $data['slug'] = SlugGeneratorService::generateSlug('about_us', $data['title']);

           if (!empty($data['image_media_id_media_id'])) {
            $data['image_media_id'] = $data['image_media_id_media_id'];
        }

        // Check if content already exists for this language (excluding current record)
        $checkDataExist = $this->hasBaseDataForLanguage($data['language'], $id);

        if ($checkDataExist) {
            return false; // Controller will handle error message
        }

        return $this->repository->updateRecord($id, $data);
    }

    public function getActiveAboutUs()
    {
        return $this->repository->getActiveAboutUs();
    }
    public function hasBaseDataForLanguage($language, $excludeId = null)
    {
        return $this->repository->hasBaseDataForLanguage($language, $excludeId);
    }

}
