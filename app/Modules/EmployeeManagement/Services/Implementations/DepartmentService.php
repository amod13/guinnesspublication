<?php

namespace App\Modules\EmployeeManagement\Services\Implementations;

use App\Modules\EmployeeManagement\DTOs\DepartmentDTO;
use App\Modules\EmployeeManagement\Repositories\Interfaces\DepartmentRepositoryInterface;
use App\Modules\EmployeeManagement\Services\Interfaces\DepartmentServiceInterface;

class DepartmentService extends BaseService implements DepartmentServiceInterface
{
    protected $deptrepo;

    public function __construct(DepartmentRepositoryInterface $deptRepo) {
        parent::__construct($deptRepo);
        $this->deptrepo = $deptRepo;
    }

    public function createWithOrder($data)
    {
        $order = $this->getMaxOrder();
        $data['display_order'] = $order + 1;
        return $this->createRecord($data);
    }


    public function getPaginatedData($perPage, $search)
    {
        $data = $this->getPaginationWithSearch($perPage, $search, [
            'name',
            'status'
        ]);
        return DepartmentDTO::fromCollection($data);
    }

}
