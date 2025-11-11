<?php
namespace App\Modules\Publication\Repositories\Interfaces;

use App\Core\Repositories\Interface\BaseRepositoryInterface;

interface GalleryCategoryRepositoryInterface extends BaseRepositoryInterface
{
    public function getActiveGalleryCategories();
}