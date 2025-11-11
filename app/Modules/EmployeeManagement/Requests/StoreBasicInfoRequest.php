<?php

namespace App\Modules\EmployeeManagement\Requests;

use App\Modules\EmployeeManagement\Enums\BloodGroupEnum;
use App\Modules\EmployeeManagement\Enums\EmploymentTypeEnum;
use App\Modules\EmployeeManagement\Enums\GenderEnum;
use App\Modules\EmployeeManagement\Enums\JobCategoryEnum;
use App\Modules\EmployeeManagement\Enums\MaritalStatusEnum;
use App\Modules\EmployeeManagement\Enums\RelationshipEnum;
use App\Modules\EmployeeManagement\Enums\StatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class StoreBasicInfoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        $data =  [
            //1. personal information
            'full_name'         => 'required|string|max:255',
            'date_of_birth' => ['required', 'date', 'before:today'],
            'nationality' => 'required|string|max:255',
            // personal info table check
            'citizenship_no'    => 'required|string|unique:employee_information,citizenship_no',
            'issued_district' => 'required|string|max:255',
            'pan_no'            => 'required|string|unique:employee_information,pan_no',
            // enum
            'gender'       => ['required', new Enum(GenderEnum::class)],
            'marital_status' => ['required', new Enum(MaritalStatusEnum::class)],
            'blood_group' => ['required', new Enum(BloodGroupEnum::class)],


            // 2. contanct information
            'mobile_number'           => [
                'required',
                'digits:10',
                Rule::unique('emp_contact_information', 'mobile_number')
            ],
            'email_address'          => [
                'required',
                'email',
                Rule::unique('emp_contact_information', 'email_address')
            ],
            'permanent_address'      => 'required|string',
            'temporary_address'     => 'required|string',
            'emergency_contact_name' => 'required|string',
            'emergency_contact_number' => [
                'required',
                'digits:10',
                Rule::unique('emp_contact_information', 'emergency_contact_number')
            ],
            'relationship'           => ['required', new Enum(RelationshipEnum::class)],

            // 3. employee details
            'date_of_joining' => ['required', 'date', 'before_or_equal:today'], // drop this rule if future joining is allowed
            'date_of_leaving' => ['nullable', 'date', 'after:date_of_joining'], // or 'after_or_equal:date_of_joining'


            'department_id'    => 'required|exists:emp_departments,id',
            'sub_department_id' => 'nullable|exists:emp_sub_departments,id',
            'designation_id'   => 'required|exists:emp_designations,id',
            'employment_type'  => ['required', new Enum(EmploymentTypeEnum::class)],
            'job_category'     => ['required', new Enum(JobCategoryEnum::class)],
            'employee_status' => ['required', new Enum(StatusEnum::class)],
            'reporting_manager' => 'nullable|string|max:255',
            'date_of_joining' => 'required|date|before_or_equal:today',

            // but latter on can be joined to user table based on desingation

        ];

        return $data;
    }
    public function withValidator($validator)
    {
        $validator->sometimes('date_of_leaving', ['required', 'date', 'after:date_of_joining'], function ($input) {
            return (int) $input->employee_status === 0; // INACTIVE
        });
    }
}
