<?php
namespace App\Modules\Publication\Repositories\Implementations;

use App\Core\Repositories\Implementation\BaseRepository;
use App\Modules\Publication\Models\GalleryCategory;
use App\Modules\Publication\Repositories\Interfaces\GalleryCategoryRepositoryInterface;

class GalleryCategoryRepository extends BaseRepository implements GalleryCategoryRepositoryInterface
{
    protected $model;
    public function __construct(GalleryCategory $model)
    {
        parent::__construct($model);
    }

    public function getActiveGalleryCategories()
    {
        $data = $this->model
            ->select('id', 'title', 'thumbnail_image_id', 'display_order', 'description')
            ->where('status', 1)
            ->orderBy('display_order', 'asc')
            ->get();
        return $data;
    }
}
