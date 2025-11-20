<?php

declare(strict_types=1);

namespace App\Modules\Publication\DTOs\Authors;

use App\Core\DTOs\BaseDto;

class AuthorsDto extends BaseDto
{
    public ?int $id;
    public string $name;
    public ?string $email;
    public ?string $address;
    public ?string $content;
    public string $status;
    public ?int $display_order;
    public ?int $image_media_id;
    public ?int $image;

    /**
     * Data for table listing
     */
    public function getDataForTable($data): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'address' => $this->address,
            'content' => $this->content,
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
