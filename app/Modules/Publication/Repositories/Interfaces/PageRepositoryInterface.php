<?php
namespace App\Modules\Publication\Repositories\Interfaces;

use App\Core\Repositories\Interface\BaseRepositoryInterface;

interface PageRepositoryInterface extends BaseRepositoryInterface
{
    public function getActivePages();
    public function getSinglePageBySlug($slug);
}
