<?php

namespace App\Modules\EmployeeManagement\Services\Implementations;

use App\Modules\EmployeeManagement\Repositories\Interfaces\BaseRepositoryInterface;
use App\Modules\EmployeeManagement\Services\Interfaces\BaseServiceInterface;

class BaseService implements BaseServiceInterface
{
    protected $repository;

    public function __construct(BaseRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAll()
    {
        return $this->repository->getAll();
    }

    public function createRecord($data)
    {
        return $this->repository->createRecord($data);
    }

    public function editRecord($id)
    {
        return $this->repository->editRecord($id);
    }

    public function updateRecord($id, array $data)
    {
        return $this->repository->updateRecord($id, $data);
    }

    public function deleteRecord($id)
    {
        return $this->repository->deleteRecord($id);
    }

    public function getPaginationWithSearch($perPage, $search, $searchFields = [])
    {
        return $this->repository->getPaginationWithSearch($perPage, $search, $searchFields);
    }

    public function getMaxOrder()
    {
        return $this->repository->getMaxOrder();
    }

    public function editRecordByIdAndEmployeeId($id, $employeeId)
    {
        return $this->repository->editRecordByIdAndEmployeeId($id, $employeeId);
    }

    public function listRecordByEmployeeId($employeeId)
    {
        return $this->repository->listRecordByEmployeeId($employeeId);
    }

    public function deleteRecordByIdAndEmployeeId($id, $employeeId)
    {
        return $this->repository->deleteRecordByIdAndEmployeeId($id, $employeeId);
    }

    public function updateRecordByIdAndEmployeeId($data, $id, $employeeId)
    {
        return $this->repository->updateRecordByIdAndEmployeeId($data, $id, $employeeId);
    }

    public function editRecordByEmployeeId($employeeId)
    {
        return $this->repository->editRecordByEmployeeId($employeeId);
    }

    public function getActiveRecord()
    {
        return $this->repository->getActiveRecord();
    }
}
