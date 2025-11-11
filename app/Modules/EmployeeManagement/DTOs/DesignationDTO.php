<?php

namespace App\Modules\EmployeeManagement\DTOs;


class DesignationDTO extends BaseDTO
{
    public int $id;
    public string $name;
    public bool $status;
}
