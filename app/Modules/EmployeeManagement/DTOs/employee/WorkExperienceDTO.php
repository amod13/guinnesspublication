<?php

namespace App\Modules\EmployeeManagement\DTOs\employee;

use App\Constant\Uploads;
use Illuminate\Http\UploadedFile;

class WorkExperienceDTO
{
    public ?int $id;
    public ?int $employee_id;
    public string $organization_name;
    public string $designation;
    public string $from_date;
    public string $to_date;
    public string $reason_for_leaving;
    public UploadedFile|string|null $experience_letter;

    public function __construct(
        ?int $id,
        ?int $employee_id,
        string $organization_name,
        string $designation,
        string $from_date,
        string $to_date,
        string $reason_for_leaving,
        UploadedFile|string|null $experience_letter
    ) {
        $this->id = $id;
        $this->employee_id = $employee_id;
        $this->organization_name = $organization_name;
        $this->designation = $designation;
        $this->from_date = $from_date;
        $this->to_date = $to_date;
        $this->reason_for_leaving = $reason_for_leaving;
        $this->experience_letter = $experience_letter;
    }

    /**
     * Create DTO from validated request data or array
     */
    public static function fromData($record): self
    {
        $data = is_array($record) ? $record : (array) $record;

        return new self(
            $data['id'] ?? null,
            $data['employee_id'] ?? null,
            $data['organization_name'],
            $data['designation'],
            $data['from_date'],
            $data['to_date'],
            $data['reason_for_leaving'],
            $data['experience_letter'] ?? '',
        );
    }

    /**
     * Convert DTO to array for storage (e.g., DB insert/update)
     */
    public function toArray()
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
            $result[] = $dto->listWorkExperience();
        }

        return $result;
    }


    public function listWorkExperience(): array
    {
        return [
            'id' => $this->id,
            'employee_id' => $this->employee_id,
            'organization_name' => $this->organization_name,
            'designation' => $this->designation,
            'from_date' => $this->from_date,
            'to_date' => $this->to_date,
            'reason_for_leaving' => $this->reason_for_leaving,
        ];
    }

    public static function fromDB($record): self
    {
        // Build the experience letter URL
        $record->experience_letter = asset(
            'storage/' . $record->employee_id . '/' . Uploads::WORK_EXPERIENCE . '/' . $record->experience_letter
        );

        return new self(
            $record->id ?? null,
            $record->employee_id ?? null,
            $record->organization_name ?? '',
            $record->designation ?? '',
            $record->from_date ?? '',
            $record->to_date ?? '',
            $record->reason_for_leaving ?? '',
            $record->experience_letter
        );
    }
}
