<?php

namespace App\Modules\Publication\Repositories\Interfaces;

use App\Core\Repositories\Interface\BaseRepositoryInterface;

interface BookRepositoryInterface extends BaseRepositoryInterface
{
    public function getRecordById($id);
    public function getPublicAllowedPages($id);
    public function getPublishBooksByHighLightType($highlightType);
    public function getAuthorsByBookId($bookId, $language);
    public function getBookIdBySlug($slug);
    public function getRelatedBookByCategoryId($categoryId, $excludeBookId);
    public function searchBookByKeyword($keyword);
    public function getBooksByCategoryId($categoryId);
    public function getActiveBooks();
}
