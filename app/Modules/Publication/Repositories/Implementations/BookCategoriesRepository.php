<?php

namespace App\Modules\Publication\Repositories\Implementations;

use App\Core\Repositories\Implementation\BaseRepository;
use App\Modules\Publication\Repositories\Interfaces\BookCategoriesRepositoryInterface;
use App\Modules\Publication\Models\BookCategories;

class BookCategoriesRepository extends BaseRepository implements BookCategoriesRepositoryInterface
{
    public function __construct(BookCategories $model)
    {
        parent::__construct($model);
    }

    public function getActiveBookCategories()
    {
        return $this->model->where('status', 'active')
        ->where('language', session('language', 'en'))
        ->select('id', 'name','thumbnail_image','slug')->orderBy('name', 'asc')
        ->get();
    }
}
