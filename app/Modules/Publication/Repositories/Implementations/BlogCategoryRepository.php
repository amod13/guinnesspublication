<?php

namespace App\Modules\Publication\Repositories\Implementations;

use App\Core\Repositories\Implementation\BaseRepository;
use App\Modules\Publication\Models\BlogCategory;
use App\Modules\Publication\Repositories\Interfaces\BlogCategoryRepositoryInterface;


class BlogCategoryRepository extends BaseRepository implements BlogCategoryRepositoryInterface
{
    public function __construct(BlogCategory $model)
    {
        parent::__construct($model);
    }

    public function getActiveBlogCategories()
    {
        return $this->model->where('status', true)->orderBy('display_order')->get();
    }
}