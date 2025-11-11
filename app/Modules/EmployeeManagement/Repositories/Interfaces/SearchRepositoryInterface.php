<?php

namespace App\Modules\EmployeeManagement\Repositories\Interfaces;

interface SearchRepositoryInterface
{
    public function getPaginatedEmployeeList($searchField, $perPage);
}
