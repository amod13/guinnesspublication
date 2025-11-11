<?php

namespace App\Modules\Publication\Constants;

class UploadPaths
{
    public const PATHS = [
        'THUMBNAIL' => [
            'path' => 'uploads/publication/thumbnails',
            'prefix' => 'thumb',
        ],
        'DOCUMENTS' => [
            'path' => 'uploads/publication/documents',
            'prefix' => 'doc',
        ],
    ];
}