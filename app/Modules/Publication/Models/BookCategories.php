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
        'content',
    ];

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('display_order');
    }


public function childrenRecursive()
{
    return $this->children()->with('childrenRecursive');
}

// Accessor: all nested children count
public function getTotalChildrenCountAttribute()
{
    return $this->childrenRecursive->count();
}
}
