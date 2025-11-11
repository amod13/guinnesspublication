<?php

declare(strict_types=1);

namespace App\Modules\Publication\DTOs\BookCategories;

use App\Core\DTOs\BaseDto;

class BookCategoriesDto extends BaseDto
{
    public ?int $id;
    public string $name;
    public string $status;
    public ?string $slug;
    public ?string $content;
    public ?int $parent_id;
    public ?int $thumbnail_image_media_id;
    public ?int $display_order;


    public function getDataForTable($data): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'display_order' => $this->display_order
        ];
    }

    public function getDataForSelectOption(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
