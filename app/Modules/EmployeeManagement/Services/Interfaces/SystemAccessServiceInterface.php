<?php

namespace App\Modules\EmployeeManagement\Services\Interfaces;

interface SystemAccessServiceInterface extends BaseServiceInterface
{
    public function storeSystemAccess($data, $employeeId);

    public function getSystemAccessRecord($employeeId);

    public function updateSystemAccess($data, $employeeId, $id);

}
