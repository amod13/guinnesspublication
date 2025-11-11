<?php

namespace App\Modules\EmployeeManagement\Services\Interfaces;

interface SubDepartmentServiceInterface extends BaseServiceInterface
{
    public function getPaginatedData($perPage, $search);

    public function createWithOrder($data);

    public function getByDepartmentId($deptid);
}
