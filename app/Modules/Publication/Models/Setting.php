<?php

namespace App\Modules\Publication\Models;

use App\Core\Traits\HasMediaLibrary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory,HasMediaLibrary;

    protected $table = 'settings';

    protected $fillable = [
        'site_name',
        'address',
        'phone',
        'language_id',
        'show_all_page',
        'accept_multiple',
        'helpline',
    ];

    protected $casts = [
        'locations' => 'array',
        'field_offices' => 'array',
    ];

    // Global settings (shared across languages)
    protected $globalFields = [
        'email',
        'logo',
        'favicon',
        'facebook',
        'twitter',
        'instagram',
        'youtube',
        'tiktok',
        'whatsapp',
        'google_map',
        'locations',
        'field_offices',
        'default_image',
    ];
}
