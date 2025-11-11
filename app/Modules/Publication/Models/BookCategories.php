<?php

namespace App\Modules\Publication\Models;

use App\Core\Model\BaseModel;

class BookCategories extends BaseModel
{
    protected $table = 'book_categories';

    protected $fillable = [
        'name',
        'slug',
        'content',
        'parent_id',
        'status',
        'display_order',
        'language',
        'thumbnail_image',
    ];
}
