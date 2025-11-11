<?php

namespace App\Modules\EmployeeManagement\Models;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    protected $table = "emp_designations";

    protected $fillable = [
        'name',
        'display_order',
        'status'
    ];
}
