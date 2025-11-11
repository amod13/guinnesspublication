<?php

namespace App\Modules\EmployeeManagement\Models;

use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model
{
    protected $table = "emp_work_experiences";

    protected $fillable = [
        'employee_id',
        'organization_name',
        'designation',
        'from_date',
        'to_date',
        'reason_for_leaving',
        'experience_letter',
    ];
}
