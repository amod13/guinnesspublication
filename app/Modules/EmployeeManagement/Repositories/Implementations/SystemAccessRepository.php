<?php

namespace App\Modules\EmployeeManagement\Repositories\Implementations;

use App\Modules\EmployeeManagement\Models\SystemAccess;
use App\Modules\EmployeeManagement\Repositories\Interfaces\SystemAccessRepositoryInterface;
use Illuminate\Support\Facades\DB;

class SystemAccessRepository extends BaseRepository implements SystemAccessRepositoryInterface
{
    public function __construct(SystemAccess $model)
    {
        parent::__construct($model);
    }

    // Additional methods specific to SystemAccess can be added here

    public function updateSystemAccessRecord($data, $employeeId)
    {
        return DB::table('emp_system_accesses')
            ->where('employee_id', $employeeId)   // use correct column name
            ->update([
                'can_access' => $data['status'],  // only update this column
            ]);
    }

    public function getEmployeeFullName($employeeId)
    {
        return DB::table('employee_information')
            ->where('id', $employeeId)
            ->value('full_name');
    }
}
