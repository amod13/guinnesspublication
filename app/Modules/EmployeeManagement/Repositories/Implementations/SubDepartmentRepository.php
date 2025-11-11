<?php

namespace App\Modules\EmployeeManagement\Repositories\Implementations;

use App\Modules\EmployeeManagement\Models\SubDepartment;
use App\Modules\EmployeeManagement\Repositories\Interfaces\SubDepartmentRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SubDepartmentRepository extends BaseRepository implements SubDepartmentRepositoryInterface
{
    public function __construct(SubDepartment $model)
    {
        parent::__construct($model);
    }


    public function getSubDepartmentPagination($perPage, $search)
    {
        $query = DB::table('emp_sub_departments')
            ->select('emp_sub_departments.*', 'emp_departments.name as department_name')
            ->leftJoin('emp_departments', 'emp_sub_departments.dept_id', '=', 'emp_departments.id');


        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('emp_sub_departments.name', 'LIKE', "%{$search}%")
                    ->orWhere('emp_sub_departments.status', 'LIKE', "%{$search}%")
                    ->orWhere('emp_departments.name', 'LIKE', "%{$search}%");
            });
        }
        $query->orderBy('display_order', 'desc');

        return $query->paginate($perPage);
    }

    public function getSubDepartmentByDeptId($deptId)
    {
        return DB::table('emp_sub_departments')
            ->where('dept_id', $deptId)
            ->get();
    }
}
