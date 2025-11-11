<?php

namespace App\Modules\Publication\Services\Implementations;

use App\Core\Services\Implementation\BaseService;
use App\Modules\Publication\DTOs\Marketings\MarketingsDto;
use App\Modules\Publication\Repositories\Interfaces\MarketingsRepositoryInterface;
use App\Modules\Publication\Services\Interfaces\MarketingsServiceInterface;

class MarketingsService extends BaseService implements MarketingsServiceInterface
{
    public function __construct(MarketingsRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function createRecord($data)
    {
        $data['user_id'] = $this->getCurrentLoginUserId();

        return $this->repository->createRecord($data);
    }

    public function updateRecord($data, int $id)
    {
        $data['user_id'] = $data['user_id'] ?? $this->getCurrentLoginUserId();
        return $this->repository->updateRecord($id, $data);
    }

    public function getPaginatedSearchResults(int $perPage, $searchTerm = [])
    {
        $filters = [
            'search' => $searchTerm['keywords'] ?? null,
            'status' => $searchTerm['status'] ?? null,
            'user_id' => $this->getCurrentLoginUserId(),
            // 🔥 new date range structure
            'date_filters' => [
                'visit_date' => [
                    'from' => $searchTerm['FromDate'] ?? null,
                    'to' => $searchTerm['ToDate'] ?? now()->toDateString(),
                ],
            ],
        ];

        return $this->hasPaginatedWithSearch(
            perPage: $perPage,
            filters: $filters,
            searchableFields: ['school_name', 'school_address', 'school_phone', 'school_email', 'remarks'],
            dtoClass: MarketingsDto::class,
            useFromCollection: false,
            sortDir: 'asc',
            sortBy: 'display_order',
            baseQuery: null,
            filterField: 'user_id',
            filterId: $this->getCurrentLoginUserId(),
        );
    }
}
