<?php

namespace App\Modules\Publication\Repositories\Interfaces;

use App\Core\Repositories\Interface\BaseRepositoryInterface;

interface VmgRepositoryInterface extends BaseRepositoryInterface
{
    public function getActiveVmg();
}
