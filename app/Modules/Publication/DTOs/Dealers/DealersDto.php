<?php

declare(strict_types=1);

namespace App\Modules\Publication\DTOs\Dealers;

use App\Core\DTOs\BaseDto;

class DealersDto extends BaseDto
{
    public ?int $id;
    public string $name;
    public ?string $phone_number;
    public ?string $email;
    public ?string $address;
    public ?string $pan_number;
    public ?string $contact_person;
    public string $status;
    public ?int $display_order;

    /**
     * Data for table listing
     */
    public function getDataForTable($data): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'address' => $this->address,
            'contact_person' => $this->contact_person,
            'status' => $this->status,
            'display_order' => $this->display_order,
        ];
    }

    /**
     * Data for select/dropdown options
     */
    public function getDataForSelectOption(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
