<?php

namespace App\Modules\Publication\Models;

use App\Core\Model\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Authors extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'address',
        'status',
        'display_order',
        'content',
        'image',
        'slug',
        'language',
     ];

    protected $casts = [
        'status' => 'string',
    ];
}
