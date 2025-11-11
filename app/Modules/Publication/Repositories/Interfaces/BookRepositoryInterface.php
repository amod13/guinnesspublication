<?php

namespace App\Modules\Publication\Repositories\Interfaces;
use App\Core\Repositories\Interface\BaseRepositoryInterface;

interface BookRepositoryInterface extends BaseRepositoryInterface
{
    public function getRecordById($id);
    public function getPublicAllowedPages($id);
    public function getPublishBooksByHighLightType($highlightType);
    public function getSingleBookBySlug($slug);
}
