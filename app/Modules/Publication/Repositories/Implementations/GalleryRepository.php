<?php
namespace App\Modules\Publication\Repositories\Implementations;

use App\Core\Repositories\Implementation\BaseRepository;
use App\Modules\Publication\Models\Gallery;
use App\Modules\Publication\Repositories\Interfaces\GalleryRepositoryInterface;
use Illuminate\Support\Facades\DB;

class GalleryRepository extends BaseRepository implements GalleryRepositoryInterface
{
    protected $model;
    public function __construct(Gallery $model)
    {
        parent::__construct($model);
    }

    public function getGalleriesByCategory($categoryId)
    {
        return $this->model
            ->with('category')
            ->where('category_id', $categoryId)
            ->get();
    }

    public function getGroupedByCategory($perPage, $search = null)
    {
        $query = $this->model
            ->select('category_id', DB::raw('COUNT(*) as total_items'), DB::raw('MIN(id) as sample_id'))
            ->with(['category:id,title'])
            ->groupBy('category_id');

        if ($search) {
            $query->whereHas('category', function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%');
            });
        }

        return $query->paginate($perPage);
    }

    public function getGalleryData()
    {
        return $this->model
            ->with('category')
            ->get();
    }
}
