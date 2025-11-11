<?php

namespace App\Modules\EmployeeManagement\Repositories\Implementations;

use App\Modules\EmployeeManagement\Models\EducationalBackground;
use App\Modules\EmployeeManagement\Repositories\Interfaces\EducationRepositoryInterface;

class EducationRepository extends BaseRepository implements EducationRepositoryInterface
{
    public function __construct(EducationalBackground $model)
    {
        parent::__construct($model);
    }
}
