<?php
namespace App\Modules\Publication\Repositories\Interfaces;

use App\Core\Repositories\Interface\BaseRepositoryInterface;

interface SettingRepositoryInterface extends BaseRepositoryInterface
{
    public function getFirstData();
    public function getByLanguage();
    public function getGlobalSettings();
    public function getCombinedSettings();
}
