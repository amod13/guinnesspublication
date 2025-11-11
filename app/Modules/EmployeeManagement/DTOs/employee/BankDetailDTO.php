<?php

namespace App\Modules\EmployeeManagement\DTOs\employee;

class BankDetailDTO
{
    public ?int $id;
    public ?int $employee_id;
    public float $basic_salary;
    public float $allowances;
    public float $deductions;
    public string $bank_name;
    public string $bank_account_number;
    public string $provident_fund_no;
    public string $status;

    public function __construct(
        ?int $id = null,
        ?int $employee_id = null,
        float $basic_salary,
        float $allowances,
        float $deductions,
        string $bank_name,
        string $bank_account_number,
        string $provident_fund_no,
        string $status
    ) {
        $this->id = $id;
        $this->employee_id = $employee_id;
        $this->basic_salary = $basic_salary;
        $this->allowances = $allowances;
        $this->deductions = $deductions;
        $this->bank_name = $bank_name;
        $this->bank_account_number = $bank_account_number;
        $this->provident_fund_no = $provident_fund_no;
        $this->status = $status;
    }

    public static function fromData($record): self
    {
        $data = is_array($record) ? $record : (array) $record;

        return new self(
            $data['id'] ?? null,
            $data['employee_id'] ?? null,
            $data['basic_salary'],
            $data['allowances'],
            $data['deductions'],
            $data['bank_name'],
            $data['bank_account_number'],
            $data['provident_fund_no'],
            $data['status']
        );
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public static function fromCollection($items): array
    {
        $result = [];

        foreach ($items as $item) {
            // $item is an Eloquent model, cast to array for fromData()
            $data = (array) $item->getAttributes();
            $dto = self::fromData($data);
            $result[] = $dto->listBankDetails();
        }

        return $result;
    }

    public function listBankDetails(): array
    {
        return [
            'id' => $this->id,
            'employee_id' => $this->employee_id,
            'basic_salary' => $this->basic_salary,
            'allowances' => $this->allowances,
            'deductions' => $this->deductions,
            'bank_name' => $this->bank_name,
            'bank_account_number' => $this->bank_account_number,
            'provident_fund_no' => $this->provident_fund_no,
            'status' => $this->status,
        ];
    }

    public static function editData($data): self
    {
        return new self(
            $data->id,
            $data->employee_id,
            $data->basic_salary,
            $data->allowances,
            $data->deductions,
            $data->bank_name,
            $data->bank_account_number,
            $data->provident_fund_no,
            $data->status
        );
    }
}
