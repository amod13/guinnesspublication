<?php

namespace App\Modules\Publication\Services\Interfaces;

use App\Core\Services\Interface\BaseServiceInterface;

interface BlogCategoryServiceInterface extends BaseServiceInterface
{
    public function getActiveBlogCategories();
    public function getPaginatedSearchResults(int $perPage, ?string $search = null);
}
