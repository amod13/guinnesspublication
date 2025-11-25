<?php

namespace App\Modules\Publication\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavouriteBook extends Model
{
    use HasFactory;

    protected $table = 'favourite_books';

    protected $fillable = [
        'user_id',
        'book_id',
    ];
}