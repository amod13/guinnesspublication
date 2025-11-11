<?php
namespace App\Modules\EmployeeManagement\Models;


use Illuminate\Database\Eloquent\Model;

class ContactInformation extends Model
{
    protected $table = "emp_contact_information";

    protected $fillable = [
        'employee_id',
        'mobile_number',
        'email_address',
        'permanent_address',
        'temporary_address',
        'emergency_contact_name',
        'emergency_contact_number',
        'relationship',
    ];

}


