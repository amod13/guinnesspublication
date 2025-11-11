<?php

namespace App\Modules\EmployeeManagement\Repositories\Interfaces;

interface SystemAccessRepositoryInterface extends BaseRepositoryInterface
{
    public function updateSystemAccessRecord($data, $employeeId);

    public function getEmployeeFullName($employeeId);
}
