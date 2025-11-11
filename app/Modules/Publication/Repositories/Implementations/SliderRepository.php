<?php
namespace App\Modules\Publication\Repositories\Implementations;

use App\Core\Repositories\Implementation\BaseRepository;
use App\Modules\Publication\Models\Slider;
use App\Modules\Publication\Repositories\Interfaces\SliderRepositoryInterface;

class SliderRepository extends BaseRepository implements SliderRepositoryInterface
{
    protected $model;
    public function __construct(Slider $model)
    {
        parent::__construct($model);
    }
    public function getActiveSliders()
    {
        $data = $this->model
            ->where('language', app()->getLocale())
            ->select('id', 'title', 'background_image', 'background_image_1', 'background_image_2', 'display_order', 'subtitle', 'description')
            ->where('status', 1)
            ->orderBy('display_order', 'asc')
            ->get();
        return $data;
    }
}
