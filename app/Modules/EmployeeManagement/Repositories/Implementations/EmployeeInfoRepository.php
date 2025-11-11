<?php

namespace App\Modules\EmployeeManagement\Repositories\Implementations;

use App\Modules\EmployeeManagement\Models\EmployeeInformation;
use App\Modules\EmployeeManagement\Repositories\Interfaces\EmployeeInfoRepositoryInterface;

class EmployeeInfoRepository extends BaseRepository implements EmployeeInfoRepositoryInterface
{
    public function __construct(EmployeeInformation $model) {
        parent::__construct($model);
    }
}
