<?php

namespace App\Modules\Publication\Repositories\Implementations;

use App\Core\Repositories\Implementation\BaseRepository;
use App\Modules\Publication\Repositories\Interfaces\MarketingsRepositoryInterface;
use App\Modules\Publication\Models\Marketings;

class MarketingsRepository extends BaseRepository implements MarketingsRepositoryInterface
{
    public function __construct(Marketings $model)
    {
        parent::__construct($model);
    }

    public function getPaginatedSearchResults($perPage, $searchTerm)
    {
        $query = $this->model->query();

        if ($searchTerm) {
            $query->where('name', 'LIKE', "%{$searchTerm}%");
        }

        return $query->orderBy('display_order')->paginate($perPage);
    }
}