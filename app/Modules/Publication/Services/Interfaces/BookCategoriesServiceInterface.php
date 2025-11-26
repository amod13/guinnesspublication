<?php

namespace App\Modules\Publication\Services\Interfaces;
use App\Core\Services\Interface\BaseServiceInterface;

interface BookCategoriesServiceInterface extends BaseServiceInterface
{
    public function getPaginatedSearchResults(int $perPage, ?string $search = null);
    public function getActiveBookCategories();
    public function getCategoryIdBySlug($slug);
    public function searchCategories($data);
    public function getBookCategories();
    public function getBookCategoryWithChildren();
}
