<?php

namespace App\View\Composers;

use App\Modules\Publication\Repositories\Implementations\MenuRepo;
use App\Modules\Publication\Repositories\Interfaces\AboutUsRepositoryInterface;
use App\Modules\Publication\Services\Interfaces\SettingServiceInterface;
use Illuminate\View\View;

class CommonDataPrepareforWeb
{
    protected $settingRepo, $menuRepo,$aboutUsService;

    public function __construct()
    {
        $this->settingRepo = resolve(SettingServiceInterface::class);
        $this->menuRepo = resolve(MenuRepo::class);
        $this->aboutUsService = resolve(AboutUsRepositoryInterface::class);
    }

    public function compose(View $view)
    {
        $setting = $this->settingRepo->getFirstData();
        $menus = $this->menuRepo->getMenudataWithChildren();
        $aboutUs = $this->aboutUsService->getAboutTagline();

        // Get existing data from view
        $existingData = $view->getData()['data'] ?? [];

        // Merge setting with existing data
        $existingData['setting'] = $setting;
        $existingData['menus'] = $menus;
        $existingData['aboutTagline'] = $aboutUs;



        $view->with('data', $existingData);
    }
}
