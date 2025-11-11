<?php

namespace App\Modules\EmployeeManagement\DTOs\employee;

class SystemAccessDTO
{
    public ?int $id;
    public ?int $employee_id;
    public string $name;
    public ?string $password;
    public int $status;
    public ?int $role_id;

    public function __construct(
        ?int $id,
        ?int $employee_id,
        string $name,
        ?string $password = null,
        int $status,
        ?int $role_id,
    ) {
        $this->id = $id;
        $this->employee_id = $employee_id;
        $this->name = $name;
        $this->password = $password;
        $this->status = $status;
        $this->role_id = $role_id;
    }

    public static function fromData($record): self
    {
        $data = is_array($record) ? $record : (array) $record;

        return new self(
            $data['id'] ?? null,
            $data['employee_id'] ?? null,
            $data['username'] ?? '',
            $data['password'] ?? '',
            $data['status'],
            $data['role_id'],
        );
    }



    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public static function editDetail(object $data): array
    {
        return (new self(
            $data->id ?? null,
            $data->employee_id ?? null,
            $data->name ?? '',
            null,
            $data->status,
            $data->role_id,
        ))->toView();
    }

        public function toView()
    {
        return [
            'id'          => $this->id,
            'employee_id' => $this->employee_id,
            'username'        => $this->name,
            'status'      => $this->status,
            'role_id'     => $this->role_id
        ];
    }
}
