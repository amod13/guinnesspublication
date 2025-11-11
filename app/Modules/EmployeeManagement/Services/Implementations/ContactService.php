<?php

namespace App\Modules\EmployeeManagement\Services\Implementations;

use App\Modules\EmployeeManagement\Repositories\Interfaces\ContactInfoRepositoryInterface;
use App\Modules\EmployeeManagement\Services\Interfaces\ContactSerivceInterface;

class ContactService extends BaseService implements ContactSerivceInterface
{
    public function __construct(ContactInfoRepositoryInterface $repository) {
        parent::__construct($repository);
    }
}
