<?php

namespace App\Modules\Publication\Repositories\Implementations;

use App\Modules\Publication\Models\Menu;


class MenuRepo
{
    public function getMenudataWithChildren()
    {
        $menus = Menu::with('children')->where('language', session('language', 'en'))->orderBy('position')->get();
        return $menus;
    }
}
