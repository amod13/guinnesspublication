<?php

namespace App\Modules\Publication\Services\Interfaces;
use App\Core\Services\Interface\BaseServiceInterface;

interface BookCategoriesServiceInterface extends BaseServiceInterface
{
    public function getPaginatedSearchResults(int $perPage, ?string $search = null);
    public function getActiveBookCategories();
}
