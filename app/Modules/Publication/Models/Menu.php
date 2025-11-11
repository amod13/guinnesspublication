<?php

namespace App\Modules\Publication\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $table = 'menus';
    protected $fillable = [
        'title',
        'url',
        'parent_id',
        'position',
        'type',
        'page_id',
        'status',
        'business_sector_id',
        'menu_type_id',
        'image',
        'is_mega_menu',
        'description',
        'blockquote',
        'is_display_web',
        'menu_icon',
        'is_thematic',
        'slug',
        'language',
    ];


    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('position');
    }

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }
    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id');
    }
}
