<?php

namespace App\Modules\EmployeeManagement\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryDetails extends Model
{
    protected $table = "emp_salary_details";

    protected $fillable = [
        'employee_id',
        'basic_salary',
        'allowances',
        'deductions',
        'bank_name',
        'bank_account_number',
        'provident_fund_no',
        'status',
    ];
}
