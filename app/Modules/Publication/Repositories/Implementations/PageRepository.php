<?php
namespace App\Modules\Publication\Repositories\Implementations;

use App\Core\Repositories\Implementation\BaseRepository;
use App\Modules\Publication\Models\Page;
use App\Modules\Publication\Repositories\Interfaces\PageRepositoryInterface;

class PageRepository extends BaseRepository implements PageRepositoryInterface
{
    protected $model;
    public function __construct(Page $model)
    {
        parent::__construct($model);
    }

    public function getActivePages()
    {
        return $this->model
            ->where('status', 1)
            ->orderBy('display_order', 'asc')
            ->get();
    }

    public function getSinglePageBySlug($slug)
    {
        return $this->model
            ->where('slug', $slug)
            ->where('language', app()->getLocale())
            ->where('status', 1)
            ->first();
    }

    public function getAllWithRelations()
    {
        return $this->model->query();
    }
}
