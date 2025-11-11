<?php

namespace App\Modules\EmployeeManagement\Models;


use Illuminate\Database\Eloquent\Model;

class EmploymentDetail extends Model
{
    protected $table = "emp_employment_details";

    protected $fillable = [
        'employee_id',
        'date_of_joining',
        'date_of_leaving',
        'department_id',
        'sub_department_id',
        'designation_id',
        'employment_type',
        'job_category',
        'employee_status',
        'reporting_manager',
    ];
}
