<?php

namespace App\Modules\Publication\Services\Interfaces;

use App\Core\Services\Interface\BaseServiceInterface;

interface GalleryServiceInterface extends BaseServiceInterface
{
    public function getPaginatedSearchResults(int $perPage, ?string $search = null);
    public function getGalleriesByCategory($categoryId);
    public function getGalleryData();
}
