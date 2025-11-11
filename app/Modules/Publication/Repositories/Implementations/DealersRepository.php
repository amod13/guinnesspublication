<?php

namespace App\Modules\Publication\Repositories\Implementations;

use App\Core\Repositories\Implementation\BaseRepository;
use App\Modules\Publication\Repositories\Interfaces\DealersRepositoryInterface;
use App\Modules\Publication\Models\Dealers;

class DealersRepository extends BaseRepository implements DealersRepositoryInterface
{
    public function __construct(Dealers $model)
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