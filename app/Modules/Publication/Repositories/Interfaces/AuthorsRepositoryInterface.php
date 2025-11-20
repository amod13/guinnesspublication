<?php

namespace App\Modules\Publication\Repositories\Interfaces;

use App\Core\Repositories\Interface\BaseRepositoryInterface;

interface AuthorsRepositoryInterface extends BaseRepositoryInterface
{
    public function getActiveAuthors($language);
}
