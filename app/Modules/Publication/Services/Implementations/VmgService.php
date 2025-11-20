<?php

namespace App\Modules\Publication\Services\Implementations;

use App\Core\Services\Implementation\BaseService;
use App\Core\Utils\SlugGeneratorService;
use App\Modules\Publication\DTOs\Vmg\VmgDto;
use App\Modules\Publication\Repositories\Interfaces\VmgRepositoryInterface;
use App\Modules\Publication\Services\Interfaces\VmgServiceInterface;

class VmgService extends BaseService implements VmgServiceInterface
{
    public function __construct(VmgRepositoryInterface $repository)
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
            dtoClass: VmgDto::class,
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
        $data = $this->convertToArray($data);

        if (isset($data['features'])) {
            $features = [];

            if (!empty($data['features']['features'])) {
                $features['features'] = array_values(array_filter($data['features']['features'], function($item) {
                    return !empty($item);
                }));
            }

            $data['features'] = $features;
        }

        $data['slug'] = SlugGeneratorService::generateSlug('vmgs', $data['title']);

        if (!empty($data['front_image_id_media_id'])) {
            $data['front_image_id'] = $data['front_image_id_media_id'];
        }

        if (!empty($data['back_image_id_media_id'])) {
            $data['back_image_id'] = $data['back_image_id_media_id'];
        }

        $data['language'] = session('language', 'en');
        return $this->repository->createRecord($data);
    }

    public function updateRecord($data, $id)
    {
        $data = $this->convertToArray($data);

        if (!empty($data['front_image_id_media_id'])) {
            $data['front_image_id'] = $data['front_image_id_media_id'];
        }

        if (!empty($data['back_image_id_media_id'])) {
            $data['back_image_id'] = $data['back_image_id_media_id'];
        }

        if (isset($data['features'])) {
            $features = [];

            if (!empty($data['features']['features'])) {
                $features['features'] = array_filter($data['features']['features'], function($item) {
                    return !empty($item);
                });
            }

            $data['features'] = $features;
        }

        $data['language'] = session('language', 'en');
        $data['slug'] = $data['slug'] ?? SlugGeneratorService::generateSlug('vmgs', $data['title']);
        return $this->repository->updateRecord($id, $data);
    }

    protected function convertToArray($data)
    {
        if (is_object($data) && method_exists($data, 'toArray')) {
            return $data->toArray();
        }
        return (array) $data;
    }
    public function getActiveVmg()
    {
        return $this->repository->getActiveVmg();
    }
}
