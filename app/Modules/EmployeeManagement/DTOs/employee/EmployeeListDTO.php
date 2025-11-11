<?php

namespace App\Modules\EmployeeManagement\DTOs\employee;

use App\Modules\EmployeeManagement\Enums\EmployeeStatusEnum;
use App\Modules\EmployeeManagement\Enums\EmploymentTypeEnum;
use App\Modules\EmployeeManagement\Enums\JobCategoryEnum;
use App\Modules\EmployeeManagement\Enums\StatusEnum;
use Illuminate\Pagination\LengthAwarePaginator;

class EmployeeListDTO
{
    public int $id;
    public string $employee_code;
    public string $full_name;
    public string $mobile_number;
    public string $email_address;

    // Enum value labels
    public string $job_category;
    public string $employee_status;

    public string $date_of_joining;
    public ?string $reporting_manager;

    // Joined data
    public string $department_name;
    public ?string $sub_department_name;
    public string $designation_name;
    public string $employment_type;

    public function __construct(
        int $id,
        string $employee_code,
        string $full_name,
        string $mobile_number,
        string $email_address,
        string $job_category,
        string $employee_status,
        string $date_of_joining,
        ?string $reporting_manager,
        string $department_name,
        ?string $sub_department_name,
        string $designation_name,
        string $employment_type,
    ) {
        $this->id = $id;
        $this->employee_code = $employee_code;
        $this->full_name = $full_name;
        $this->mobile_number = $mobile_number;
        $this->email_address = $email_address;

        $this->job_category = $job_category;
        $this->employee_status = $employee_status;

        $this->date_of_joining = $date_of_joining;
        $this->reporting_manager = $reporting_manager;
        $this->department_name = $department_name;
        $this->sub_department_name = $sub_department_name;
        $this->designation_name = $designation_name;
        $this->employment_type = $employment_type;
    }

    /**
     * Map a single stdClass or array item to DTO
     */
    public static function fromData(object $data): self
    {
        return new self(
            $data->employee_id,
            $data->employee_code,
            $data->full_name,
            $data->mobile_number,
            $data->email_address,
            JobCategoryEnum::from($data->job_category)->label(),
            StatusEnum::from($data->employee_status)->label(),
            $data->date_of_joining,
            $data->reporting_manager ?? null,
            $data->department_name,
            $data->sub_department_name ?? null,
            $data->designation_name,
            EmploymentTypeEnum::from($data->employment_type)->label(),
        );
    }

    /**
     * Transform all items inside paginator using DTO
     */
    public static function fromCollection(LengthAwarePaginator $items): LengthAwarePaginator
    {
        $items->getCollection()->transform(
            fn($item) => self::fromData($item)->toArray()
        );
        return $items;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
