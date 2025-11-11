<?php

namespace App\Modules\EmployeeManagement\Services\Interfaces;

interface EducationServiceInterface extends BaseServiceInterface
{
    public function storeEducation($data, $employeeId);

    public function deleteEducationDetail($id, $employeeId);

    public function updateEducationDetail($data, $id, $employeeId);
}
