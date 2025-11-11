<?php

namespace App\Modules\EmployeeManagement\DTOs\employee;



class ContactInfoDTO
{
    public ?int $id;
    public int $employee_id;
    public string $mobile_number;
    public string $email_address;
    public string $permanent_address;
    public string $temporary_address;
    public string $emergency_contact_name;
    public string $emergency_contact_number;
    public int $relationship; // enum

    public function __construct(
        ?int $id,
        int $employee_id,
        string $mobile_number,
        string $email_address,
        string $permanent_address,
        string $temporary_address,
        string $emergency_contact_name,
        string $emergency_contact_number,
        int $relationship
    ) {
        $this->id = $id;
        $this->employee_id = $employee_id;
        $this->mobile_number = $mobile_number;
        $this->email_address = $email_address;
        $this->permanent_address = $permanent_address;
        $this->temporary_address = $temporary_address;
        $this->emergency_contact_name = $emergency_contact_name;
        $this->emergency_contact_number = $emergency_contact_number;
        $this->relationship = $relationship;
    }

    public static function fromData($record): self
    {
        $data = is_array($record) ? $record : $record->toArray();

        return new self(
            $data['id'] ?? null,
            (int)($data['employee_id'] ?? 0),
            (string)($data['mobile_number'] ?? ''),
            (string)($data['email_address'] ?? ''),
            (string)($data['permanent_address'] ?? ''),
            (string)($data['temporary_address'] ?? ''),
            (string)($data['emergency_contact_name'] ?? ''),
            (string)($data['emergency_contact_number'] ?? ''),
            (int)($data['relationship'] ?? 0),
        );
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
