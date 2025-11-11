<?php

namespace App\Modules\Publication\Models;

use App\Core\Model\BaseModel;

class Slider extends BaseModel
{
    protected $table = 'sliders';

    protected $fillable = [
        'title',
        'subtitle',
        'display_order',
        'slug',
        'background_image',
        'background_image_1',
        'background_image_2',
        'status',
        'description',
        'video_url',
        'language',
    ];
}
