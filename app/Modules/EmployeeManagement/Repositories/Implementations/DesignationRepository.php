<?php

namespace App\Modules\EmployeeManagement\Repositories\Implementations;

use App\Modules\EmployeeManagement\Models\Designation;
use App\Modules\EmployeeManagement\Repositories\Interfaces\DesignationRepositoryInterface;

class DesignationRepository extends BaseRepository implements DesignationRepositoryInterface
{
    public function __construct(Designation $model) {
        parent::__construct($model);
    }
}
