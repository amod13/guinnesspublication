<?php

namespace App\Modules\EmployeeManagement\DTOs\employee;

use App\Constant\Uploads;
use Illuminate\Http\UploadedFile;

class EducationDTO
{
    public ?int $id;
    public int $employee_id;
    public string $degree;
    public string $institution_name;
    public int $year_of_passing;
    public string $grade_percentage;
    public string|UploadedFile $certificate;

    public function __construct(
        ?int $id,
        int $employee_id,
        string $degree,
        string $institution_name,
        int $year_of_passing,
        string $grade_percentage,
        string|UploadedFile $certificate
    ) {
        $this->id = $id;
        $this->employee_id = $employee_id;
        $this->degree = $degree;
        $this->institution_name = $institution_name;
        $this->year_of_passing = $year_of_passing;
        if (is_string($grade_percentage) && !is_numeric($grade_percentage)) {
            $this->grade_percentage = strtoupper($grade_percentage);
        } else {
            $this->grade_percentage = $grade_percentage;
        }

        $this->certificate = $certificate;
    }

    public static function fromData($record): self
    {
        $data = is_array($record) ? $record : (array) $record;

        return new self(
            $data['id'] ?? null,
            (int)($data['employee_id'] ?? 0),
            (string)($data['degree'] ?? ''),
            (string)($data['institution_name'] ?? ''),
            (int)($data['year_of_passing'] ?? 0),
            (string)($data['grade_percentage'] ?? ''),
            $data['certificate'] ?? '',
        );
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }


    public static function fromCollection(iterable $items): array
    {
        $result = [];

        foreach ($items as $item) {
            // $item is an Eloquent model, cast to array for fromData()
            $data = (array) $item->getAttributes();
            $dto = self::fromData($data);
            $result[] = $dto->listEducation();
        }

        return $result;
    }

    private function listEducation(): array
    {
        return [
            'id' => $this->id,
            'employee_id' => $this->employee_id,
            'degree' => $this->degree,
            'institution_name' => $this->institution_name,
            'year_of_passing' => $this->year_of_passing,
            'grade_percentage' => $this->grade_percentage,
        ];
    }



    public static function fromDB($data): self
    {

        $data->certificate = asset(
            'storage/' . $data->employee_id . '/' . Uploads::EDUCATION_FOLDER . '/' . $data->certificate
        );

        return new self(
            $data->id ?? null,
            (int) $data->employee_id ?? 0,
            (string) $data->degree ?? '',
            (string) $data->institution_name ?? '',
            (int) $data->year_of_passing ?? 0,
            (string) $data->grade_percentage ?? '',
            $data->certificate
        );
    }
}
