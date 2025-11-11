<?php

namespace App\Modules\EmployeeManagement\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = "emp_departments";

    protected $fillable = ['name', 'display_order', 'status'];
}
