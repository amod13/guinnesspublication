<?php

namespace App\Modules\EmployeeManagement\Services\Implementations;

use App\Modules\EmployeeManagement\Repositories\Interfaces\EmployeeDetailRepositoryInterface;
use App\Modules\EmployeeManagement\Services\Interfaces\EmpDetailServiceInterface;

class EmpDetailService extends BaseService implements EmpDetailServiceInterface
{
    public function __construct(EmployeeDetailRepositoryInterface $repository) {
        parent::__construct($repository);
    }
}
