<?php

namespace App\Modules\EmployeeManagement\Models;

use Illuminate\Database\Eloquent\Model;

class SystemAccess extends Model
{
    protected $table = "emp_system_accesses";

    protected $fillable = [
        'employee_id',
        'can_access'
    ];
}


