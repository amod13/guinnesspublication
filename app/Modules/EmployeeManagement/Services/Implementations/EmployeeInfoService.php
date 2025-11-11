<?php

namespace App\Modules\EmployeeManagement\Services\Implementations;

use App\Modules\EmployeeManagement\Repositories\Interfaces\EmployeeInfoRepositoryInterface;
use App\Modules\EmployeeManagement\Services\Interfaces\EmployeeInfoServiceInterface;

class EmployeeInfoService extends BaseService implements EmployeeInfoServiceInterface
{
    public function __construct(EmployeeInfoRepositoryInterface $repository) {
        parent::__construct($repository);
    }
}
