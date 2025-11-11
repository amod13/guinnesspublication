<?php

declare(strict_types=1);

namespace App\Modules\Publication\DTOs\Gallery;

use App\Core\DTOs\BaseDto;

class GalleryDto extends BaseDto
{
    public ?int $id;
    public ?int $category_id;
    public ?string $caption;
    public ?string $image;
    public ?string $video_url;
    public string $file_type;

    public function getDataForTable($data): array
    {
        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'caption' => $this->caption ?? '-',
            'file_type' => $this->file_type,
            'image' => $this->image,
            'video_url' => $this->video_url,
        ];
    }

    public function getDataForSelectOption(): array
    {
        return [
            'id' => $this->id,
            'caption' => $this->caption,
        ];
    }
}