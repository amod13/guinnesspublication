<?php

namespace App\Modules\Publication\Repositories\Interfaces;

use App\Core\Repositories\Interface\BaseRepositoryInterface;

interface AboutUsRepositoryInterface extends BaseRepositoryInterface
{
    public function getActiveAboutUs();
    public function getAboutTagline();
    public function hasBaseDataForLanguage($language, $excludeId = null);
}
