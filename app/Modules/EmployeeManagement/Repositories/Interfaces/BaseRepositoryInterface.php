<?php

namespace App\Modules\EmployeeManagement\Repositories\Interfaces;


interface BaseRepositoryInterface
{
    public function getAll();

    public function createRecord($data);

    public function editRecord($id);

    public function updateRecord($id, array $data);

    public function deleteRecord($id);

    public function getPaginationWithSearch($perPage, $search, $searchFields = []);

    public function getMaxOrder();

    public function editRecordByIdAndEmployeeId($id, $employeeId);

    public function listRecordByEmployeeId($employeeId);

    public function deleteRecordByIdAndEmployeeId($id, $employeeId);

    public function updateRecordByIdAndEmployeeId($data, $id, $employeeId);

    public function editRecordByEmployeeId($employeeId);

    public function getActiveRecord();
}
