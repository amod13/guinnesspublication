<?php

namespace App\Modules\EmployeeManagement\DTOs;

class SubDepartmentDTO extends BaseDTO
{
    public int $id;
    public string $name;
    public int $dept_id;
    public int $status;
}
