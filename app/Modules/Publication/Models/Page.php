<?php

namespace App\Modules\Publication\Models;

use App\Core\Traits\HasMediaLibrary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory, HasMediaLibrary;

    protected $table = 'pages';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'thumbnail_image_id',
        'meta_data',
        'display_order',
        'status',
        'language',
    ];

    protected $casts = [
        'meta_data' => 'array',
    ];
}
