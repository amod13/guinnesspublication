<?php

namespace App\Modules\Publication\Models;

use App\Core\Traits\HasMediaLibrary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory, HasMediaLibrary;
    protected $fillable = [
        'title',
        'slug',
        'thumbnail_image',
        'display_order',
        'status',
        'language',
        'parent_id',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'status' => 'boolean',
        'display_order' => 'integer',
        'parent_id' => 'integer',
    ];

    public function parent()
    {
        return $this->belongsTo(BlogCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(BlogCategory::class, 'parent_id');
    }
}
