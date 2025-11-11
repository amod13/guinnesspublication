<?php

namespace App\Modules\EmployeeManagement\Services\Interfaces;

interface DepartmentServiceInterface extends BaseServiceInterface
{
    public function createWithOrder($data);

    public function getPaginatedData($perPage, $search);

}
