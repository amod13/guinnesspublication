<?php

namespace App\Modules\Publication\Services\Interfaces;

use App\Core\Services\Interface\BaseServiceInterface;

interface SettingServiceInterface extends BaseServiceInterface
{
    public function getByLanguage();
    public function getGlobalSettings();
    public function getFirstData();
}
