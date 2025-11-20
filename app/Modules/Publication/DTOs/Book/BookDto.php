<?php

declare(strict_types=1);

namespace App\Modules\Publication\DTOs\Book;

use App\Core\DTOs\BaseDto;

class BookDto extends BaseDto
{
    public ?int $id;
    public string $title;
    public string $status;
    public ?string $slug;
    public ?string $content;
    public ?int $thumbnail_image_media_id;
    public ?int $pdf_file_media_id;
    public ?int $category_id;
    public ?int $display_order;
    public ?string $public_pdf_pages;
    public ?string $highlights;
    public ?int $author_id;

    public function getDataForTable($data): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'status' => $this->status,
            'display_order' => $this->display_order
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
