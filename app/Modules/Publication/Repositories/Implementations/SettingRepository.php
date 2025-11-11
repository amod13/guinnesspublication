<?php
namespace App\Modules\Publication\Repositories\Implementations;

use App\Core\Repositories\Implementation\BaseRepository;
use App\Modules\Publication\Models\Setting;
use App\Modules\Publication\Repositories\Interfaces\SettingRepositoryInterface;
use Illuminate\Support\Facades\DB;

class SettingRepository extends BaseRepository implements SettingRepositoryInterface
{
    protected $model;
    public function __construct(Setting $model)
    {
        parent::__construct($model);
    }

        public function getFirstData()
    {
        return $this->getCombinedSettings();
    }

    public function getByLanguage()
    {
        return $this->model->where('language', session('language', 'en'))->first();
    }

    public function getGlobalSettings()
    {
        return $this->model->first();
    }

    public function getCombinedSettings()
    {
        $languageSettings = $this->model->where('language', session('language', 'en'))->first();
        $globalSettings = $this->model->first();

        if (!$languageSettings && !$globalSettings) {
            return null;
        }

        // If no language-specific settings exist, create empty object
        if (!$languageSettings) {
            $languageSettings = new Setting();
            $languageSettings->language = session('language', 'en');
        }

        // Merge global fields into language settings
        if ($globalSettings) {
            $languageSettings->email = $globalSettings->email;
            $languageSettings->logo = $globalSettings->logo;
            $languageSettings->favicon = $globalSettings->favicon;
            $languageSettings->facebook = $globalSettings->facebook;
            $languageSettings->twitter = $globalSettings->twitter;
            $languageSettings->instagram = $globalSettings->instagram;
            $languageSettings->youtube = $globalSettings->youtube;
            $languageSettings->tiktok = $globalSettings->tiktok;
            $languageSettings->whatsapp = $globalSettings->whatsapp;
            $languageSettings->google_map = $globalSettings->google_map;
            $languageSettings->default_image = $globalSettings->default_image;
        }

        return $languageSettings;
    }

}
