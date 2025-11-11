<?php

namespace App\Modules\EmployeeManagement\Services\Implementations;

use App\Modules\EmployeeManagement\DTOs\DesignationDTO;
use App\Modules\EmployeeManagement\Repositories\Interfaces\DesignationRepositoryInterface;
use App\Modules\EmployeeManagement\Services\Interfaces\DesignationServiceInterface;

class DesignationService extends BaseService implements DesignationServiceInterface
{
    protected $designationRepo;
    public function __construct(DesignationRepositoryInterface $designationRepo) {
        parent::__construct($designationRepo);
    }

    public function getPaginatedData($perPage, $search)
    {
        $seachField = ['name', 'status'];
        $data = $this->getPaginationWithSearch($perPage, $search, $seachField);
        return DesignationDTO::fromCollection($data);
    }

    public function createWithOrder($data)
    {
        $order = $this->getMaxOrder();
        $data['display_order'] =  $order + 1;
        return $this->createRecord($data);
    }
}
