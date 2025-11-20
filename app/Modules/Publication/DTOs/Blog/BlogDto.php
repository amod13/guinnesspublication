<?php

declare(strict_types=1);

namespace App\Modules\Publication\DTOs\Blog;

use App\Core\DTOs\BaseDto;

class BlogDto extends BaseDto
{
    public ?int $id;
    public ?int $blog_category_id;
    public string $title;
    public string $slug;
    public ?string $excerpt;
    public ?string $content;
    public ?array $tags;
    public ?string $featured_image;
    public ?string $thumbnail_image;
    public ?string $video_url;
    public ?int $author_id;
    public ?string $author_name;
    public ?string $published_date;
    public bool $is_published;
    public int $views_count;
    public int $display_order;
    public bool $status;
    public ?int $thumbnail_image_media_id;

    public function getDataForTable($data): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'blog_category_id' => $this->blog_category_id ?? '-',
            'author_name' => $this->author_name ?? '-',
            'is_published' => $this->is_published ? '1' : '0',
            'status' => $this->status ? '1' : '0',
            'display_order' => $this->display_order,
            'views_count' => $this->views_count,
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
