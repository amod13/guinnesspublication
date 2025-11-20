<?php

namespace App\Modules\Publication\Services\Interfaces;

use App\Core\Services\Interface\BaseServiceInterface;


interface BlogServiceInterface extends BaseServiceInterface
{
    public function getPublishedBlogs();
    public function getPaginatedSearchResults(int $perPage, ?string $search = null);
    public function getBlogBySlug($slug);
    public function getBlogByCategorySlug($slug);
}
