<?php

namespace App\Modules\EmployeeManagement\Repositories\Interfaces;


interface SubDepartmentRepositoryInterface extends BaseRepositoryInterface
{
    public function getSubDepartmentPagination($perPage, $search);

    public function getSubDepartmentByDeptId($deptId);
}
