<?php

declare(strict_types=1);

namespace App\Modules\Publication\DTOs\AboutUs;

use App\Core\DTOs\BaseDto;

class AboutUsDto extends BaseDto
{
    public ?int $id;
    public string $title;
    public string $slug;
    public ?string $subtitle;
    public ?string $description;
    public ?int $image_media_id;
    public ?string $status;
    public mixed $features;
    public ?string $years_of_experience;
    public ?string $happy_clients;
    public int $display_order;
    public ?int $image_media_id_media_id;

    public function getDataForTable($data): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'status' => $this->status,
            'display_order' => $this->display_order,
        ];
    }

    public function getDataForSelectOption(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
        ];
    }
}
