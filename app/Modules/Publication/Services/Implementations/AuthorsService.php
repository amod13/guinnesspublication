<?php

namespace App\Modules\Publication\Services\Implementations;

use App\Core\Services\Implementation\BaseService;
use App\Core\Utils\SlugGeneratorService;
use App\Modules\Publication\DTOs\Authors\AuthorsDto;
use App\Modules\Publication\Repositories\Interfaces\AuthorsRepositoryInterface;
use App\Modules\Publication\Services\Interfaces\AuthorsServiceInterface;
use App\Modules\UserManagement\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthorsService extends BaseService implements AuthorsServiceInterface
{
    protected $userRepository;

    public function __construct(
        AuthorsRepositoryInterface $repository,
        UserRepositoryInterface $userRepository
    ) {
        parent::__construct($repository);
        $this->userRepository = $userRepository;
    }

    public function getPaginatedSearchResults(int $perPage, $searchTerm = [])
    {
        $filters = [
            'search' => $searchTerm['keywords'] ?? null,
            'status' => $searchTerm['status'] ?? null,
        ];

        return $this->hasPaginatedWithSearch(
            perPage: $perPage,
            filters: $filters,
            searchableFields: ['name', 'email', 'address'],
            dtoClass: AuthorsDto::class,
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
        if (isset($data['image_media_id']) && $data['image_media_id']) {
            $data['image'] = $data['image_media_id'];
        }
        $data['slug'] = SlugGeneratorService::generateSlug('authors', $data['name']);
        $data['language'] = session('language', 'en');

        return $this->repository->createRecord($data);
    }

    public function updateRecord($data, $id)
    {
        if (isset($data['image_media_id']) && $data['image_media_id']) {
            $data['image'] = $data['image_media_id'];
        }
        $data['slug'] = $data['slug'] ?? SlugGeneratorService::generateSlug('authors', $data['name']);
        $data['language'] = session('language', 'en');

        return $this->repository->updateRecord($id, $data);
    }

    public function getActiveAuthors()
    {
        return $this->repository->getActiveAuthors(session('language', 'en'));
    }
}
