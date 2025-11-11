<?php

namespace App\Modules\EmployeeManagement\Models;


use Illuminate\Database\Eloquent\Model;

class EmployeeInformation extends Model
{
    protected $table = "employee_information";

    protected $fillable = [
        'employee_code',
        'display_order',
        'full_name',
        'gender',
        'date_of_birth',
        'marital_status',
        'nationality',
        'citizenship_no',
        'issued_district',
        'pan_no',
        'blood_group',
    ];


}
