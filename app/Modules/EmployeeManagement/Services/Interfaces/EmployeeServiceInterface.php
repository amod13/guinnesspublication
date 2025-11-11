<?php

namespace App\Modules\EmployeeManagement\Services\Interfaces;

interface EmployeeServiceInterface extends BaseServiceInterface
{
    public function getEmployeeDetail($id);

    public function storeBasicEmployeeDetail($data);

    public function getBasicEmployeeDetail($employeeId);

    public function updateBasicInfo($data, int $employeeId);

    public function searchEmployee($searchField, $perPage);

    public function checkEmployeeExist($employeeId);

    public function exist(array $tables, $employeeId);

    public function getCompletedSteps($employeeId): array;

    // public function getMaxAllowedStepIndex(array $completedSteps): int;
}
