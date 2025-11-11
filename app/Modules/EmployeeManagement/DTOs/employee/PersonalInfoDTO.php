<?php

namespace App\Modules\EmployeeManagement\DTOs\employee;

class PersonalInfoDTO
{
    public ?int $id;
    public string $full_name;
    public int $gender;
    public string $date_of_birth;
    public int $marital_status;
    public string $nationality;
    public string $citizenship_no;
    public string $issued_district;
    public string $pan_no;
    public ?int $blood_group;

    public function __construct(
        ?int $id = null,
        string $full_name,
        int $gender,
        string $date_of_birth,
        int $marital_status,
        string $nationality,
        string $citizenship_no,
        string $issued_district,
        string $pan_no,
        ?int $blood_group
    ) {
        $this->id = $id;
        $this->full_name = $full_name;
        $this->gender = $gender;
        $this->date_of_birth = $date_of_birth;
        $this->marital_status = $marital_status;
        $this->nationality = $nationality;
        $this->citizenship_no = $citizenship_no;
        $this->issued_district = $issued_district;
        $this->pan_no = $pan_no;
        $this->blood_group = $blood_group;
    }


    public static function fromData($record)
    {
        $data = is_array($record) ? $record : $record->toArray();

        return new self(
            id: isset($data['id']) ? (int)$data['id'] : null, // works in edit case
            full_name: (string)($data['full_name'] ?? ''),
            gender: isset($data['gender']) ? (int)$data['gender'] : 0,
            date_of_birth: (string)($data['date_of_birth'] ?? ''),
            marital_status: isset($data['marital_status']) ? (int)$data['marital_status'] : 0,
            nationality: (string)($data['nationality'] ?? ''),
            citizenship_no: (string)($data['citizenship_no'] ?? ''),
            issued_district: (string)($data['issued_district'] ?? ''),
            pan_no: (string)($data['pan_no'] ?? ''),
            blood_group: isset($data['blood_group']) ? (int)$data['blood_group'] : null,
        );
    }


    /**
     * For saving to DB (just raw values)
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
