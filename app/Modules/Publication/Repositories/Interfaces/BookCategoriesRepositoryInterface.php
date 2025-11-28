<?php

namespace App\Modules\Publication\Repositories\Interfaces;

use App\Core\Repositories\Interface\BaseRepositoryInterface;

interface BookCategoriesRepositoryInterface extends BaseRepositoryInterface
{
    public function getActiveBookCategories();
    public function getCategoryIdBySlug($slug);
    public function searchCategories($data);
    public function getBookCategories();
    public function getBookCategoryWithChildren();
    public function getDataForTable();
     public function parentCategory($id);
     public function getActiverCategoryNotInParent();
     public function getAllCategoryWithSubCategory($slug);
     public function hasParent($id);
     public function deleteCategoryWithChildren($id);
     public function getCategoriesWithParentAndChild();
}
