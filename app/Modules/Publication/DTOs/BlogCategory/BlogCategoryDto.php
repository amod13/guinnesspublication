<?php

declare(strict_types=1);

namespace App\Modules\Publication\DTOs\BlogCategory;

use App\Core\DTOs\BaseDto;

class BlogCategoryDto extends BaseDto
{
    public ?int $id;
    public string $title;
    public ?string $slug;
    public ?string $thumbnail_image;
    public int $display_order;
    public bool $status;
    public ?int $parent_id;
    public ?int $thumbnail_image_media_id;

    public function getDataForTable($data): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'status' => $this->status ? '1' : '0',
            'display_order' => $this->display_order,
            'parent_id' => $this->parent_id ?? '-',
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
