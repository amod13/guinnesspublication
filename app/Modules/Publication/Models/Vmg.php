<?php

namespace App\Modules\Publication\Models;

use App\Core\Traits\HasMediaLibrary;
use App\Modules\MediaLibarary\Models\MediaLibrary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vmg extends Model
{
    use HasFactory, HasMediaLibrary;

    protected $table = 'vmgs';

    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'features',
        'video_url',
        'front_image_id',
        'back_image_id',
        'status',
        'language',
        'display_order',
    ];

    protected $casts = [
        'status' => 'boolean',
        'features' => 'array',
    ];

    public function frontImage()
    {
        return $this->belongsTo(MediaLibrary::class, 'front_image_id');
    }

    public function backImage()
    {
        return $this->belongsTo(MediaLibrary::class, 'back_image_id');
    }
}
