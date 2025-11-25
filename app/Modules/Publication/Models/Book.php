<?php

namespace App\Modules\Publication\Models;

use App\Core\Model\BaseModel;
use App\Modules\Publication\Models\Authors;
use App\Modules\Publication\Models\BookCategories;

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
        'author_id',
    ];

    public function category()
    {
        return $this->belongsTo(BookCategories::class, 'category_id', 'id');
    }

    public function author()
    {
        return $this->belongsTo(Authors::class, 'author_id');
    }

       public function favourite()
    {
        return $this->belongsToMany(
            \App\Models\User::class,   // Related model
            'favourite_books',         // Pivot table
            'book_id',                 // Foreign key on pivot for Book
            'user_id'                  // Foreign key on pivot for User
        )->withTimestamps();
    }
}
