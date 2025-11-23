<?php

namespace App\Modules\Publication\Repositories\Interfaces;

use App\Core\Repositories\Interface\BaseRepositoryInterface;

interface BlogRepositoryInterface extends BaseRepositoryInterface
{
    public function getPublishedBlogs();
    public function getBlogBySlug($slug);
    public function getBlogByCategorySlug($slug);
    public function getBookIdBySlug($slug);
    public function getRelatedBookByCategoryId($categoryId,$excludeBookId);
    public function searchBooksByKeyWord($keyword);
}
