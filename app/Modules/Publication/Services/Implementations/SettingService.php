<?php

namespace App\Modules\Publication\Services\Implementations;

use App\Core\Services\Implementation\BaseService;
use App\Core\Traits\HasPaginatedSearch;
use App\Modules\Publication\Repositories\Interfaces\SettingRepositoryInterface;
use App\Modules\Publication\Services\Interfaces\SettingServiceInterface;

class SettingService extends BaseService implements SettingServiceInterface
{
    use HasPaginatedSearch;
    public function __construct(SettingRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
    public function getByLanguage()
    {
        return $this->repository->getByLanguage();
    }
    public function getGlobalSettings()
    {
        return $this->repository->getGlobalSettings();
    }
    public function getFirstData()
    {
        return $this->repository->getFirstData();
    }

}
