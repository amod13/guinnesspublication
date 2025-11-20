<?php

namespace App\Modules\Publication\Repositories\Implementations;

use App\Core\Repositories\Implementation\BaseRepository;
use App\Modules\Publication\Models\Authors;
use App\Modules\Publication\Repositories\Interfaces\AuthorsRepositoryInterface;

class AuthorsRepository extends BaseRepository implements AuthorsRepositoryInterface
{
    public function __construct(Authors $model)
    {
        parent::__construct($model);
    }
    public function getActiveAuthors($language)
    {
        return $this->model
            ->select('authors.name', 'authors.id', 'authors.image','authors.slug')
            ->where('status', 'active')
            ->where('language', $language)
            ->orderBy('display_order', 'asc')
            ->get();
    }
}
