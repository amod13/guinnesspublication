<?php

namespace App\Modules\EmployeeManagement\Services\Implementations;

use App\Modules\EmployeeManagement\Repositories\Interfaces\BankDetailRepositoryInterface;
use App\Modules\EmployeeManagement\Services\Implementations\BaseService;
use App\Modules\EmployeeManagement\Services\Interfaces\BankDetailServiceInterface;

class BankDetailService extends BaseService implements BankDetailServiceInterface
{
    protected $repository;
    public function __construct(BankDetailRepositoryInterface $repository) {
        parent::__construct($repository);
    }

}
