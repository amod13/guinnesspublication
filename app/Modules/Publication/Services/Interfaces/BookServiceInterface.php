<?php

namespace App\Modules\Publication\Services\Interfaces;
use App\Core\Services\Interface\BaseServiceInterface;
use App\Core\Traits\HasPaginatedSearch;

interface BookServiceInterface extends BaseServiceInterface
{
    public function getPaginatedSearchResults(int $perPage, ?string $search = null);
    public function getRecordById($id);
    public function getPublishBooksByHighLightType($highlightType);
    public function getSingleBookBySlug($slug);
}
