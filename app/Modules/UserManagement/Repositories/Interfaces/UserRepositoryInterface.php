<?php
namespace App\Modules\UserManagement\Repositories\Interfaces;

use App\Core\Repositories\Interface\BaseRepositoryInterface;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function getUsers();
    public function keepLastLogin($userId);
        public function editRecordByIdAndEmployeeId($id, $employeeId);
    public function updateRecordByIdAndEmployeeId($data, $id, $employeeId);
    public function editRecordByEmployeeId($employeeId);
}
