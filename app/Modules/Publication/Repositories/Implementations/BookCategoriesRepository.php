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

    public function getDataForTable()
    {
        return $this->model
            ->whereNull('parent_id') // main category only
            ->where('language', session('language', 'en'))
            ->withCount('children'); // children count
    }

    public function getActiverCategoryNotInParent()
    {
        return $this->model
            ->withCount('children')
            ->where('status', 'active')
            ->whereNull('parent_id') // main category only
            ->where('language', session('language', 'en'))
            ->select('id', 'name', 'thumbnail_image', 'slug')->orderBy('name', 'asc')
            ->paginate(20);
    }

    public function parentCategory($id)
    {
        return $this->model
            ->select('id', 'name', 'status', 'display_order')
            ->where('parent_id', $id)
            ->with('childrenRecursive') // load recursive for count
            ->orderBy('display_order', 'asc')
            ->paginate(10)
            ->through(function ($item) {
                return [
                    'id'             => $item->id,
                    'name'           => $item->name,
                    'status'         => $item->status,
                    'display_order'  => $item->display_order,
                    'children_count' => $item->total_children_count, // accessor
                ];
            });
    }

    public function getAllCategoryWithSubCategory($slug)
    {
        return $this->model
            ->with('childrenRecursive')
            ->where('status', 'active')
            ->where('slug', $slug)
            ->where('language', session('language', 'en'))
            ->first();
    }

    public function hasParent($id)
    {
        return $this->model->where('parent_id', $id)->exists();
    }

    public function deleteCategoryWithChildren($id)
    {
        $category = $this->model->find($id);

        if (!$category) {
            return false;
        }

        // delete all children recursively
        foreach ($category->children as $child) {
            $this->deleteCategoryWithChildren($child->id);
        }

        // finally delete this category
        return $category->delete();
    }

    public function getCategoriesWithParentAndChild()
    {
        return $this->model
            ->whereNull('parent_id')
            ->with('childrenRecursive')
            ->where('status', 'active')
            ->where('language', session('language', 'en'))
            ->get();
    }
}
