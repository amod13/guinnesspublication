<?php

namespace App\Modules\EmployeeManagement\Services\Interfaces;

interface WorkExperienceServiceInterface extends BaseServiceInterface
{
    public function createWorkDetail($data, $employeeId);

    public function deleteworkDetail($id, $employeeId);

    public function updateWorkDetail($data, $id, $employeeId);
}
