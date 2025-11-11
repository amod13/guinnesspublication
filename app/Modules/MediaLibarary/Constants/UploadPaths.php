<?php

namespace App\Modules\MediaLibarary\Constants;

class UploadPaths
{
    public const PATHS = [
        'THUMBNAIL' => [
            'path' => 'uploads/medialibarary/thumbnails',
            'prefix' => 'thumb',
        ],
        'DOCUMENTS' => [
            'path' => 'uploads/medialibarary/documents',
            'prefix' => 'doc',
        ],
    ];
}