<?php
namespace App\Modules\Publication\Repositories\Interfaces;

use App\Core\Repositories\Interface\BaseRepositoryInterface;

interface GalleryRepositoryInterface extends BaseRepositoryInterface
{
    public function getGalleriesByCategory($categoryId);
    public function getGroupedByCategory($perPage, $search = null);
    public function getGalleryData();
}
