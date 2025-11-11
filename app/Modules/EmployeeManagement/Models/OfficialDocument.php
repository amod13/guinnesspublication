<?php

namespace App\Modules\EmployeeManagement\Models;

use Illuminate\Database\Eloquent\Model;

class OfficialDocument extends Model
{
    protected $table = "emp_official_documents";

    protected $fillable = [
        'employee_id',
        'resume_cv',
        'citizenship',
        'pan_card',
        'appointment_letter',
        'employee_contract',
        'photo',
    ];
}
