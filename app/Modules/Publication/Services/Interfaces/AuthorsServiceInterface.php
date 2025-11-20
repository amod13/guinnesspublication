<?php

namespace App\Modules\Publication\Services\Interfaces;

use App\Core\Services\Interface\BaseServiceInterface;

interface AuthorsServiceInterface extends BaseServiceInterface
{
    public function getPaginatedSearchResults(int $perPage, $searchTerm = []);
    public function getActiveAuthors();
}
