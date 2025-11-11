<?php

declare(strict_types=1);

namespace App\Modules\Publication\DTOs\Slider;

use App\Core\DTOs\BaseDto;

class SliderDto extends BaseDto
{
    public ?int $id;
    public string $title;
    public string $slug;
    public ?string $subtitle;
    public ?string $description;
    public ?string $video_url;
    public ?string $background_image;
    public ?string $background_image_1;
    public ?string $background_image_2;
    public ?bool $status;
    public int $display_order;
    public ?int $background_image_media_id;
    public ?int $background_image_1_media_id;
    public ?int $background_image_2_media_id;

    public function getDataForTable($data): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'subtitle' => $this->subtitle ?? '-',
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
