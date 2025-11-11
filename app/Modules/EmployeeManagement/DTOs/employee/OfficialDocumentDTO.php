<?php

namespace App\Modules\EmployeeManagement\DTOs\employee;

use App\Constant\Uploads;
use Illuminate\Http\UploadedFile;

class OfficialDocumentDTO
{
    public ?int $id;
    public ?int $employee_id;
    public UploadedFile|string|null $resume_cv;
    public UploadedFile|string|null $citizenship;
    public UploadedFile|string|null $pan_card;
    public UploadedFile|string|null $appointment_letter;
    public UploadedFile|string|null $employee_contract;
    public UploadedFile|string|null $photo;

    public function __construct(
        UploadedFile|string|null $resume_cv,
        UploadedFile|string|null $citizenship,
        UploadedFile|string|null $pan_card,
        UploadedFile|string|null $appointment_letter,
        UploadedFile|string|null $employee_contract,
        UploadedFile|string|null $photo,
        ?int $id,
        ?int $employee_id,
    ) {
        $this->resume_cv = $resume_cv;
        $this->citizenship = $citizenship;
        $this->pan_card = $pan_card;
        $this->appointment_letter = $appointment_letter;
        $this->employee_contract = $employee_contract;
        $this->photo = $photo;
        $this->id = $id;
        $this->employee_id = $employee_id;
    }

    public static function fromData(array|object $record): self
    {
        $data = is_array($record) ? $record : (array) $record;

        return new self(
            $data['resume_cv'] ?? null,
            $data['citizenship'] ?? null,
            $data['pan_card'] ?? null,
            $data['appointment_letter'] ?? null,
            $data['employee_contract'] ?? null,
            $data['photo'] ?? null,
            $data['id'] ?? null,
            $data['employee_id'] ?? null
        );
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public static function editDocumentFromDB($record)
    {
        $employeeId = $record->employee_id;
        $basePath = 'storage/' . $employeeId . '/' . Uploads::OFFICAL_DOCUMENT_FOLDER;

        return new self(
            $record->resume_cv ? asset($basePath . '/' . $record->resume_cv) : null,
            $record->citizenship ? asset($basePath . '/' . $record->citizenship) : null,
            $record->pan_card ?? ($record->pan_number ?? null) ? asset($basePath . '/' . ($record->pan_card ?? $record->pan_number)) : null,
            $record->appointment_letter ? asset($basePath . '/' . $record->appointment_letter) : null,
            $record->employee_contract ? asset($basePath . '/' . $record->employee_contract) : null,
            $record->photo ? asset($basePath . '/' . $record->photo) : null,
            $record->id,
            $employeeId
        );
    }
}
