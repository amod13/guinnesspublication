<?php

namespace App\Modules\Publication\Repositories\Interfaces;

use App\Core\Repositories\Interface\BaseRepositoryInterface;


interface BlogCategoryRepositoryInterface extends BaseRepositoryInterface
{
    public function getActiveBlogCategories();
}
