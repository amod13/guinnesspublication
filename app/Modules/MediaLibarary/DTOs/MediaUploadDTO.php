<?php

namespace App\Modules\MediaLibarary\DTOs;

class MediaUploadDTO
{
    public string $title;
    public string $filename;
    public string $originalFilename;
    public string $filePath;
    public string $mimeType;
    public string $fileType;
    public int $fileSize;
    public array $metadata;
    public ?int $uploadedBy;

    public function __construct(
        string $title,
        string $filename,
        string $originalFilename,
        string $filePath,
        string $mimeType,
        string $fileType,
        int $fileSize,
        array $metadata = [],
        ?int $uploadedBy = null
    ) {
        $this->title = $title;
        $this->filename = $filename;
        $this->originalFilename = $originalFilename;
        $this->filePath = $filePath;
        $this->mimeType = $mimeType;
        $this->fileType = $fileType;
        $this->fileSize = $fileSize;
        $this->metadata = $metadata;
        $this->uploadedBy = $uploadedBy;
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'filename' => $this->filename,
            'original_filename' => $this->originalFilename,
            'file_path' => $this->filePath,
            'mime_type' => $this->mimeType,
            'file_type' => $this->fileType,
            'file_size' => $this->fileSize,
            'metadata' => $this->metadata,
            'uploaded_by' => $this->uploadedBy,
        ];
    }
}
