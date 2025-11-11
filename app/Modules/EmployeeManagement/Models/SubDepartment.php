<?php

namespace App\Modules\EmployeeManagement\Models;

use Illuminate\Database\Eloquent\Model;

class SubDepartment extends Model
{
    protected $table = "emp_sub_departments";

    protected $fillable = [
        'name',
        'dept_id',
        'status',
        'display_order'
    ];

}
