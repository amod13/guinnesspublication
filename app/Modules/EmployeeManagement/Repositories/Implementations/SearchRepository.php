<?php

namespace App\Modules\EmployeeManagement\Repositories\Implementations;

use App\Modules\EmployeeManagement\Repositories\Interfaces\SearchRepositoryInterface;
use Illuminate\Support\Facades\DB;

class SearchRepository implements SearchRepositoryInterface
{
    public function getPaginatedEmployeeList($filters, $perPage)
    {

        $query = DB::table('employee_information')
            ->leftJoin('emp_contact_information', 'emp_contact_information.employee_id', '=', 'employee_information.id')
            ->leftJoin('emp_employment_details', 'emp_employment_details.employee_id', '=', 'employee_information.id') // left join
            ->leftJoin('emp_departments', 'emp_employment_details.department_id', '=', 'emp_departments.id')
            ->leftJoin('emp_sub_departments', 'emp_employment_details.sub_department_id', '=', 'emp_sub_departments.id')
            ->leftJoin('emp_designations', 'emp_employment_details.designation_id', '=', 'emp_designations.id')
            ->select(
                'employee_information.*',
                'emp_contact_information.*',
                'emp_employment_details.*',
                'emp_contact_information.id as contact_id',
                'emp_employment_details.id as employment_id',


                'emp_departments.name as department_name',
                'emp_sub_departments.name as sub_department_name',
                'emp_designations.name as designation_name'
            );


         
        if (isset($filters['status'])) {
            $query->where('emp_employment_details.employee_status', (int) $filters['status']);
        }

        // Dynamic Filters
        if (!empty($filters['department'])) {
            $query->where('emp_employment_details.department_id', $filters['department']);
        }

        if (!empty($filters['subDepartment'])) {
            $query->where('emp_employment_details.sub_department_id', $filters['subDepartment']);
        }

        if (!empty($filters['designation'])) {
            $query->where('emp_employment_details.designation_id', $filters['designation']);
        }


        if (!empty($filters['jobCategory'])) {
            $query->where('emp_employment_details.job_category', $filters['jobCategory']);
        }

        if (!empty($filters['employmentType'])) {
            $query->where('emp_employment_details.employment_type', $filters['employmentType']);
        }


        if (!empty($filters['Manager'])) {
            $query->where('emp_employment_details.reporting_manager', 'like', '%' . $filters['Manager'] . '%');
        }

        if (!empty($filters['FromDate']) && !empty($filters['ToDate'])) {
            // Both dates provided
            $query->whereBetween('emp_employment_details.date_of_joining', [$filters['FromDate'], $filters['ToDate']]);
        } elseif (!empty($filters['FromDate'])) {
            // Only from date
            $query->whereDate('emp_employment_details.date_of_joining', '>=', $filters['FromDate']);
        } elseif (!empty($filters['ToDate'])) {
            // Only to date
            $query->whereDate('emp_employment_details.date_of_joining', '<=', $filters['ToDate']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];

            $query->where(function ($q) use ($search) {
                $q->orWhere('employee_information.full_name', 'LIKE', "%{$search}%")
                    ->orWhere('emp_contact_information.mobile_number', 'LIKE', "%{$search}%")
                    ->orWhere('emp_contact_information.email_address', 'LIKE', "%{$search}%")
                    ->orWhere('employee_information.employee_code', 'LIKE', "%{$search}%");
            });
        }

        return $query->orderBy('employee_information.display_order', 'desc')
            ->paginate($perPage);
    }
}
