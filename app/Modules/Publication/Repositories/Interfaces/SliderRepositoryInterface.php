<?php
namespace App\Modules\Publication\Repositories\Interfaces;

use App\Core\Repositories\Interface\BaseRepositoryInterface;

interface SliderRepositoryInterface extends BaseRepositoryInterface
{
    public function getActiveSliders();
}
