<?php

namespace App\Modules\EmployeeManagement\Repositories\Implementations;

use App\Modules\EmployeeManagement\Repositories\Implementations\BaseRepository;

class DummyRepository extends BaseRepository
{
    public function __construct() {
        parent::__construct(null);
    }
}
