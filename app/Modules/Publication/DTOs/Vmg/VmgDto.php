<?php

declare(strict_types=1);

namespace App\Modules\Publication\DTOs\Vmg;

use App\Core\DTOs\BaseDto;

class VmgDto extends BaseDto
{
    public ?int $id;
    public string $title;
    public string $slug;
    public ?string $subtitle;
    public mixed $features;
    public ?string $video_url;
    public ?int $front_image_id;
    public ?int $front_image_id_media_id;
    public ?int $back_image_id;
    public ?int $back_image_id_media_id;
    public ?bool $status;
    public ?string $language;
    public int $display_order;

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
