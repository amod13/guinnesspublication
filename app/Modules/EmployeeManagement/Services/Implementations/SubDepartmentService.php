<?php

namespace App\Modules\EmployeeManagement\Services\Implementations;

use App\Modules\EmployeeManagement\Repositories\Interfaces\SubDepartmentRepositoryInterface;
use App\Modules\EmployeeManagement\Services\Interfaces\SubDepartmentServiceInterface;

class SubDepartmentService extends BaseService implements SubDepartmentServiceInterface
{
    protected $subDepartRepo;
    public function __construct(SubDepartmentRepositoryInterface $subDepartRepo) {
        parent::__construct($subDepartRepo);
        $this->subDepartRepo = $subDepartRepo;
    }

    public function getPaginatedData($perPage, $search)
    {
        $data = $this->subDepartRepo->getSubDepartmentPagination($perPage, $search);
        return $data;
    }

    public function createWithOrder($data)
    {
        $order = $this->getMaxOrder();
        $data['display_order'] = $order + 1;
        return $this->createRecord($data);
    }

    public function getByDepartmentId($deptId)
    {
        return $this->subDepartRepo->getSubDepartmentByDeptId($deptId);
    }
}
