<?php

namespace App\Modules\Publication\Repositories\Implementations;

use App\Core\Repositories\Implementation\BaseRepository;

use App\Modules\Publication\Models\Vmg;
use App\Modules\Publication\Repositories\Interfaces\VmgRepositoryInterface;

class VmgRepository extends BaseRepository implements VmgRepositoryInterface
{
    public function __construct(Vmg $model)
    {
        parent::__construct($model);
    }
    public function getActiveVmg()
    {
        return $this->model
        ->select('id', 'title','subtitle', 'front_image_id','back_image_id','display_order','features')
        ->where('status', 1)
        ->orderBy('display_order', 'asc')
        ->get();
    }
}
