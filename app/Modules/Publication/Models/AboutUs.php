<?php

namespace App\Modules\Publication\Models;

use App\Core\Model\BaseModel;
use App\Modules\MediaLibarary\Models\MediaLibrary;

class AboutUs extends BaseModel
{
    protected $table = 'about_us';

    protected $fillable = [
        'title',
        'subtitle',
        'slug',
        'description',
        'image_media_id',
        'status',
        'features',
        'years_of_experience',
        'happy_clients',
        'display_order',
        'language',
    ];

    protected $casts = [
        'features' => 'array',
    ];

    // Media relationships
    public function imageMedia()
    {
        return $this->belongsTo(MediaLibrary::class, 'image_media_id');
    }
}
