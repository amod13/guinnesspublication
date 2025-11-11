<?php

namespace App\Modules\Publication\Services\Interfaces;

use App\Core\Services\Interface\BaseServiceInterface;

interface AboutUsServiceInterface extends BaseServiceInterface
{
    public function getActiveAboutUs();
    public function hasBaseDataForLanguage($language, $excludeId = null);
}
