<?php

namespace App\Modules\EmployeeManagement\DTOs\employee;

class EmployeeDetailDTO
{
    public ?int $id;
    public int $employee_id;
    public string $date_of_joining;
    public int $department_id;
    public ?int $sub_department_id;
    public int $designation_id;
    public int $employment_type; // enum
    public int $job_category;    // enum
    public int $employee_status; // enum
    public ?string $reporting_manager;
    public ?string $date_of_leaving;

    public function __construct(
        ?int $id,
        int $employee_id,
        string $date_of_joining,
        int $department_id,
        ?int $sub_department_id,
        int $designation_id,
        int $employment_type,
        int $job_category,
        int $employee_status,
        ?string $reporting_manager,
        ?string $date_of_leaving
    ) {
        $this->id = $id;
        $this->employee_id = $employee_id;
        $this->date_of_joining = $date_of_joining;
        $this->department_id = $department_id;
        $this->sub_department_id = $sub_department_id;
        $this->designation_id = $designation_id;
        $this->employment_type = $employment_type;
        $this->job_category = $job_category;
        $this->employee_status = $employee_status;
        $this->reporting_manager = $reporting_manager;
        $this->date_of_leaving = $date_of_leaving;
    }

    public static function fromData($record): self
    {
        $data = is_array($record) ? $record : $record->toArray();

        return new self(
            $data['id'] ?? null,
            $data['employee_id'],
            $data['date_of_joining'],
            $data['department_id'],
            $data['sub_department_id'] ?? null,
            $data['designation_id'],
            $data['employment_type'],
            $data['job_category'],
            $data['employee_status'],
            $data['reporting_manager'] ?? null,
            $data['date_of_leaving'] ?? null
        );
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
