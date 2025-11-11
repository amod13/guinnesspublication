<?php

namespace App\Modules\Publication\Models;

use App\Core\Traits\HasMediaLibrary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryCategory extends Model
{
    use HasFactory, HasMediaLibrary;

    protected $table = 'gallery_categories';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'thumbnail_image_id',
        'display_order',
        'status',
    ];
}