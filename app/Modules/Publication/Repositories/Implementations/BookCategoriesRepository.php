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
            ->select('id', 'name', 'thumbnail_image', 'slug')->orderBy('name', 'asc')
            ->get();
    }

    public function getCategoryIdBySlug($slug)
    {
        $record  = $this->model->where('slug', $slug)->select('id')->first();
        return $record;
    }

    public function searchCategories($data)
    {
        $keyword = $data['keyword'] ?? null;
        $categoryId = $data['category_id'] ?? null;

        return $this->model
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('name', 'LIKE', "%{$keyword}%");
            })
            ->where('status', 'active')
            ->where('language', session('language', 'en'))
            ->when($categoryId, function ($query) use ($categoryId) {
                $query->where('id', '!=', $categoryId);
            })
            ->select('id', 'name', 'slug', 'thumbnail_image')
            ->orderBy('name', 'asc')
            ->paginate(10);
    }

    public function getBookCategories()
    {
        return $this->model->where('status', 'active')
            ->where('language', session('language', 'en'))
            ->select('id', 'name', 'thumbnail_image', 'slug')->orderBy('display_order', 'asc')
            ->paginate(10);
    }

    public function getBookCategoryWithChildren()
    {
        $menus = $this->model::with('children')->where('language', session('language', 'en'))->orderBy('display_order')->get();
        return $menus;
    }
}
