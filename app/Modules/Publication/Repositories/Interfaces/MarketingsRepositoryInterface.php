<?php

namespace App\Modules\Publication\Repositories\Interfaces;
use App\Core\Repositories\Interface\BaseRepositoryInterface;

interface MarketingsRepositoryInterface extends BaseRepositoryInterface
{
    public function getPaginatedSearchResults($perPage, $searchTerm);
}