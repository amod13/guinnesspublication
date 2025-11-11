<?php

namespace App\Modules\EmployeeManagement\Services\Interfaces;

interface DesignationServiceInterface extends BaseServiceInterface
{
    public function getPaginatedData($perPage, $search);

    public function createWithOrder($data);
}
