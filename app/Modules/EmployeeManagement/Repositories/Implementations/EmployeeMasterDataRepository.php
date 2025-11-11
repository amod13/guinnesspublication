<?php

namespace App\Modules\EmployeeManagement\Repositories\Implementations;

use App\Modules\EmployeeManagement\Repositories\Interfaces\EmployeeMasterDataRepositoryInterface;
use Illuminate\Support\Facades\DB;

class EmployeeMasterDataRepository implements EmployeeMasterDataRepositoryInterface
{
    public function getEmployeeDetail($employeeId)
    {
        $data = [
            'personalInfo'      => $this->getSingleRow('employee_information', 'id', $employeeId),
            'contactInfo'       => $this->getSingleRow('emp_contact_information', 'employee_id', $employeeId),
            'employmentDetail'  => $this->getEmploymentDetailWithJoins($employeeId),
            'systemAccess'      => $this->getSingleRow('users', 'employee_id', $employeeId),
            'officialDocument'  => $this->getSingleRow('emp_official_documents', 'employee_id', $employeeId),

            // Multiple data
            'education'         => $this->getMultiRow('emp_educational_backgrounds', 'employee_id', $employeeId),
            'workExperience'    => $this->getMultiRow('emp_work_experiences', 'employee_id', $employeeId),
            'bankDetails'       => $this->getMultiRow('emp_salary_details', 'employee_id', $employeeId),
        ];

        return $data;
    }

    private function getSingleRow(string $table, string $foreignKey, $employeeId)
    {
        return DB::table($table)->where($foreignKey, $employeeId)->first();
    }

    private function getMultiRow(string $table, string $foreignKey, $employeeId)
    {
        return DB::table($table)->where($foreignKey, $employeeId)->get();
    }

    private function getEmploymentDetailWithJoins($employeeId)
    {
        return DB::table('emp_employment_details')
            ->where('employee_id', $employeeId)
            ->leftJoin('emp_departments', 'emp_employment_details.department_id', '=', 'emp_departments.id')
            ->leftJoin('emp_sub_departments', 'emp_employment_details.sub_department_id', '=', 'emp_sub_departments.id')
            ->leftJoin('emp_designations', 'emp_employment_details.designation_id', '=', 'emp_designations.id')
            ->select(
                'emp_employment_details.*',
                'emp_departments.name as department_name',
                'emp_sub_departments.name as sub_department_name',
                'emp_designations.name as designation_name'
            )
            ->first();
    }
}
