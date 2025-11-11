<?php

declare(strict_types=1);

namespace App\Modules\Publication\DTOs\Page;

use App\Core\DTOs\BaseDto;

class PageDto extends BaseDto
{
    public ?int $id;
    public string $title;
    public string $slug;
    public ?string $content;
    public ?int $thumbnail_image_id;
    public ?int $thumbnail_image_id_media_id;
    public ?array $meta_data;
    public ?bool $status;
    public int $display_order;

    public function getDataForTable($data): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'status' => $this->status ? '1' : '0',
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
