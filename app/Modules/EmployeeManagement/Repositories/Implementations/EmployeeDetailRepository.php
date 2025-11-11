<?php

namespace App\Modules\EmployeeManagement\Repositories\Implementations;

use App\Modules\EmployeeManagement\Models\EmploymentDetail;
use App\Modules\EmployeeManagement\Repositories\Interfaces\EmployeeDetailRepositoryInterface;

class EmployeeDetailRepository extends BaseRepository implements EmployeeDetailRepositoryInterface
{
    public function __construct(EmploymentDetail $model) {
       parent::__construct($model);
    }
}
