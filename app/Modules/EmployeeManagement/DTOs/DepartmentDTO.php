<?php
namespace App\Modules\EmployeeManagement\DTOs;


class DepartmentDTO extends BaseDTO
{
    public int $id;
    public string $name;
    public bool $status;
}
