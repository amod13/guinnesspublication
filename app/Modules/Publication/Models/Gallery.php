<?php

namespace App\Modules\Publication\Models;

use App\Core\Traits\HasMediaLibrary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory, HasMediaLibrary;

    protected $table = 'gallaries';

    protected $fillable = [
        'category_id',
        'caption',
        'image',
        'video_url',
        'file_type',
    ];

    public function category()
    {
        return $this->belongsTo(GalleryCategory::class, 'category_id');
    }
}
