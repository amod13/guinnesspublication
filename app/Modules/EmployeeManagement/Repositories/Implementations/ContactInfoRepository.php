<?php

namespace App\Modules\EmployeeManagement\Repositories\Implementations;

use App\Modules\EmployeeManagement\Repositories\Interfaces\ContactInfoRepositoryInterface;
use App\Modules\EmployeeManagement\Models\ContactInformation;

class ContactInfoRepository extends BaseRepository implements ContactInfoRepositoryInterface
{
    public function __construct(ContactInformation $model)
    {
        parent::__construct($model);
    }

}
