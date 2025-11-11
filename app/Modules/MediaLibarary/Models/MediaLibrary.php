<?php

namespace App\Modules\MediaLibarary\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Modules\UserManagement\Models\User;

class MediaLibrary extends Model
{
    protected $table = 'media_library';

    protected $fillable = [
        'title',
        'filename',
        'original_filename',
        'file_path',
        'mime_type',
        'file_type',
        'file_size',
        'metadata',
        'alt_text',
        'caption',
        'description',
        'uploaded_by'
    ];

    protected $casts = [
        'metadata' => 'array',
        'file_size' => 'integer'
    ];

    protected $appends = [
        'url',
        'file_size_formatted'
    ];

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function getUrlAttribute(): string
    {
        // Handle both old and new path formats
        if (str_starts_with($this->file_path, 'uploads/')) {
            // Old format: uploads/media-library/filename
            $url = asset($this->file_path);
        } else {
            // New format: storage/media-library/filename
            $url = asset($this->file_path);
        }

        // Add strong cache busting for images
        if ($this->isImage()) {
            $url .= '?v=' . $this->updated_at->timestamp . '&r=' . time();
        }

        return $url;
    }

    public function getFileSizeFormattedAttribute(): string
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function isImage(): bool
    {
        return $this->file_type === 'image';
    }

    public function isVideo(): bool
    {
        return $this->file_type === 'video';
    }

    public function isAudio(): bool
    {
        return $this->file_type === 'audio';
    }

    public function isDocument(): bool
    {
        return $this->file_type === 'document';
    }
}
