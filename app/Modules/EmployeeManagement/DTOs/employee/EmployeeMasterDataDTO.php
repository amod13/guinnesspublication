<?php

namespace App\Modules\EmployeeManagement\DTOs\employee;

use App\Constant\Uploads;
use App\Modules\EmployeeManagement\Enums\BloodGroupEnum;
use App\Modules\EmployeeManagement\Enums\EmployeeStatusEnum;
use App\Modules\EmployeeManagement\Enums\EmploymentTypeEnum;
use App\Modules\EmployeeManagement\Enums\GenderEnum;
use App\Modules\EmployeeManagement\Enums\JobCategoryEnum;
use App\Modules\EmployeeManagement\Enums\MaritalStatusEnum;
use App\Modules\EmployeeManagement\Enums\RelationshipEnum;
use App\Modules\EmployeeManagement\Enums\StatusEnum;

class EmployeeMasterDataDTO
{
    // Personal Info
    public int $id;
    public string $employee_code;
    public string $full_name;
    public string $gender;
    public string $date_of_birth;
    public string $marital_status;
    public string $nationality;
    public string $citizenship_no;
    public string $issued_district;
    public string $pan_no;
    public string $blood_group;

    // Contact Info
    public string $mobile_number;
    public string $email_address;
    public string $permanent_address;
    public string $temporary_address;
    public string $emergency_contact_name;
    public string $emergency_contact_number;
    public string $relationship;

    // Employment Details
    public string $date_of_joining;
    public string $employment_type;
    public string $job_category;
    public string $employee_status;
    public string $reporting_manager;
    public string $department_name;
    public ?string $sub_department_name;
    public string $designation_name;

    // System Access
    public string $username;


    // Official Documents
    public string $resume_cv;
    public string $citizenship;
    public string $pan_card;
    public string $appointment_letter;
    public string $employee_contract;
    public string $photo;


    /** @var array<int, array<string, mixed>> */
    public array $education = [];

    /** @var array<int, array<string, mixed>> */
    public array $workExperience = [];

    /** @var array<int, array<string, mixed>> */
    public array $bankDetails = [];


    public static function fromRawData(array $raw): self
    {
        $dto = new self();

        // Personal Info
        $dto->id = $raw['personalInfo']->id;
        $dto->employee_code = $raw['personalInfo']->employee_code;
        $dto->full_name = $raw['personalInfo']->full_name;
        $dto->gender = GenderEnum::from($raw['personalInfo']->gender)->label();
        $dto->date_of_birth = $raw['personalInfo']->date_of_birth;
        $dto->marital_status = MaritalStatusEnum::from($raw['personalInfo']->marital_status)->label();
        $dto->nationality = $raw['personalInfo']->nationality;
        $dto->citizenship_no = $raw['personalInfo']->citizenship_no;
        $dto->issued_district = $raw['personalInfo']->issued_district;
        $dto->pan_no = $raw['personalInfo']->pan_no;
        $dto->blood_group = BloodGroupEnum::from($raw['personalInfo']->blood_group)->label();

        // Contact Info
        $dto->mobile_number = $raw['contactInfo']->mobile_number;
        $dto->email_address = $raw['contactInfo']->email_address;
        $dto->permanent_address = $raw['contactInfo']->permanent_address;
        $dto->temporary_address = $raw['contactInfo']->temporary_address;
        $dto->emergency_contact_name = $raw['contactInfo']->emergency_contact_name;
        $dto->emergency_contact_number = $raw['contactInfo']->emergency_contact_number;
        $dto->relationship = RelationshipEnum::from($raw['contactInfo']->relationship)->label();

        // Employment Details
        $dto->date_of_joining = $raw['employmentDetail']->date_of_joining;
        $dto->employment_type = EmploymentTypeEnum::from($raw['employmentDetail']->employment_type)->label();
        $dto->job_category = JobCategoryEnum::from($raw['employmentDetail']->job_category)->label();
        $dto->employee_status = EmployeeStatusEnum::from($raw['employmentDetail']->employee_status)->label();
        $dto->reporting_manager = $raw['employmentDetail']->reporting_manager;
        $dto->department_name = $raw['employmentDetail']->department_name;
        $dto->sub_department_name = $raw['employmentDetail']->sub_department_name ?? '';
        $dto->designation_name = $raw['employmentDetail']->designation_name;

        // System Access
        $dto->username = $raw['systemAccess']->name;

        // Official Documents
        $basePathOfficalDocument = 'storage/' . $raw['personalInfo']->id . '/' . Uploads::OFFICAL_DOCUMENT_FOLDER;

        $dto->resume_cv = asset($basePathOfficalDocument . '/' . $raw['officialDocument']->resume_cv);
        $dto->citizenship = asset($basePathOfficalDocument . '/' . $raw['officialDocument']->citizenship);
        $dto->pan_card = asset($basePathOfficalDocument . '/' . $raw['officialDocument']->pan_card);
        $dto->appointment_letter = asset($basePathOfficalDocument . '/' . $raw['officialDocument']->appointment_letter);
        $dto->employee_contract = asset($basePathOfficalDocument . '/' . $raw['officialDocument']->employee_contract);
        $dto->photo = asset($basePathOfficalDocument . '/' . $raw['officialDocument']->photo);



        $dto->education = collect($raw['education'])->map(function ($item) {
            return [
                'degree' => $item->degree,
                'institution_name' => $item->institution_name,
                'year_of_passing' => $item->year_of_passing,
                'grade_percentage' => $item->grade_percentage,
                'certificate' => asset('storage/' . $item->employee_id . '/' . Uploads::EDUCATION_FOLDER . '/' . $item->certificate),

                // 'certificate' => $item->certificate,
            ];
        })->toArray();

        $dto->workExperience = collect($raw['workExperience'])->map(function ($item) {
            return [
                'organization_name' => $item->organization_name,
                'designation' => $item->designation,
                'from_date' => $item->from_date,
                'to_date' => $item->to_date,
                'reason_for_leaving' => $item->reason_for_leaving,
                'experience_letter' => asset('storage/' . $item->employee_id . '/' . Uploads::WORK_EXPERIENCE . '/' . $item->experience_letter),
            ];
        })->toArray();

        $dto->bankDetails = collect($raw['bankDetails'])->map(function ($item) {
            return [
                'basic_salary' => $item->basic_salary,
                'allowances' => $item->allowances,
                'deductions' => $item->deductions,
                'bank_name' => $item->bank_name,
                'bank_account_number' => $item->bank_account_number,
                'provident_fund_no' => $item->provident_fund_no,
                'status' => StatusEnum::from($item->status)->label(),
            ];
        })->toArray();

        return $dto;
    }


    public function toStructuredArray(): array
    {
        return [
            'personalInfo' => [
                'id' => $this->id,
                'employee_code' => $this->employee_code,
                'full_name' => $this->full_name,
                'gender' => $this->gender,
                'date_of_birth' => $this->date_of_birth,
                'marital_status' => $this->marital_status,
                'nationality' => $this->nationality,
                'citizenship_no' => $this->citizenship_no,
                'issued_district' => $this->issued_district,
                'pan_no' => $this->pan_no,
                'blood_group' => $this->blood_group,
            ],
            'contactInfo' => [
                'mobile_number' => $this->mobile_number,
                'email_address' => $this->email_address,
                'permanent_address' => $this->permanent_address,
                'temporary_address' => $this->temporary_address,
                'emergency_contact_name' => $this->emergency_contact_name,
                'emergency_contact_number' => $this->emergency_contact_number,
                'relationship' => $this->relationship,
            ],
            'employmentDetail' => [
                'date_of_joining' => $this->date_of_joining,
                'employment_type' => $this->employment_type,
                'job_category' => $this->job_category,
                'employee_status' => $this->employee_status,
                'reporting_manager' => $this->reporting_manager,
                'department_name' => $this->department_name,
                'sub_department_name' => $this->sub_department_name,
                'designation_name' => $this->designation_name,
            ],
            'systemAccess' => [
                'username' => $this->username,
            ],
            'officialDocument' => [
                'resume_cv' => $this->resume_cv,
                'citizenship' => $this->citizenship,
                'pan_card' => $this->pan_card,
                'appointment_letter' => $this->appointment_letter,
                'employee_contract' => $this->employee_contract,
                'photo' => $this->photo,
            ],
            // Multiple collections
            'education' => $this->education,
            'workExperience' => $this->workExperience,
            'bankDetails' => $this->bankDetails,
        ];
    }
}
