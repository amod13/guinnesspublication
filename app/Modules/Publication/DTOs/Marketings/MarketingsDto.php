<?php

declare(strict_types=1);

namespace App\Modules\Publication\DTOs\Marketings;

use App\Core\DTOs\BaseDto;

class MarketingsDto extends BaseDto
{
    public ?int $id;
    public ?int $user_id;
    public ?string $school_name;
    public ?string $school_address;
    public ?string $school_email;
    public ?string $school_phone;
    public ?string $visit_date;
    public ?string $remarks;
    public string $status;
    public ?int $display_order;

    public function getDataForTable($data): array
    {
        return [
            'id' => $this->id,
            'school_name' => $this->school_name,
            'school_address' => $this->school_address,
            'school_email' => $this->school_email,
            'school_phone' => $this->school_email,
            'visit_date' => $this->visit_date,
            'status' => $this->status,
            'display_order' => $this->display_order,
        ];
    }

    public function getDataForSelectOption(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->school_name,
        ];
    }
}
