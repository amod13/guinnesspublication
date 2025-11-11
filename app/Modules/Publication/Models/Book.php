<?php

namespace App\Modules\Publication\Models;

use App\Core\Model\BaseModel;

class Book extends BaseModel
{
    protected $table = 'books';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'category_id',
        'status',
        'display_order',
        'thumbnail_image',
        'pdf_file',
        'public_pdf_pages',
        'language',
        'highlights',
    ];

    public function category()
    {
        return $this->belongsTo(BookCategories::class, 'category_id');
    }
}
