<?php

namespace App\Modules\Publication\Services\Interfaces;
use App\Core\Services\Interface\BaseServiceInterface;

interface BookServiceInterface extends BaseServiceInterface
{
    public function getPaginatedSearchResults(int $perPage, ?array $search = []);
    public function getRecordById($id);
    public function getPublishBooksByHighLightType($highlightType);
    public function getSingleBookBySlug($slug);
    public function searchBookByKeyword($request);
    public function giveMeBookByCategorySlug($slug);
    public function getActiveBooks();
}
