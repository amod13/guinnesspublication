<?php

namespace App\Modules\Publication\Repositories\Interfaces;
use App\Core\Repositories\Interface\BaseRepositoryInterface;

interface BookCategoriesRepositoryInterface extends BaseRepositoryInterface
{
    public function getActiveBookCategories();
}