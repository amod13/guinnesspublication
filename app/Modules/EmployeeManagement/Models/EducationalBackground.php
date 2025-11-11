<?php

namespace App\Modules\EmployeeManagement\Models;

use Illuminate\Database\Eloquent\Model;

class EducationalBackground extends Model
{
    protected $table = "emp_educational_backgrounds";

    protected $fillable = [
        'employee_id',
        'degree',
        'institution_name',
        'year_of_passing',
        'grade_percentage',
        'certificate'
    ];
}
