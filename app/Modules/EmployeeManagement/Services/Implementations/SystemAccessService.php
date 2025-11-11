<?php

namespace App\Modules\EmployeeManagement\Services\Implementations;


use App\Modules\EmployeeManagement\Repositories\Interfaces\SystemAccessRepositoryInterface;
use App\Modules\EmployeeManagement\Services\Interfaces\SystemAccessServiceInterface;
use App\Modules\UserManagement\Services\Interfaces\UserServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SystemAccessService extends BaseService implements SystemAccessServiceInterface
{
    protected $repo, $userRepo;
    public function __construct(SystemAccessRepositoryInterface $repository, UserServiceInterface $userRepo)
    {
        parent::__construct($repository);
        $this->repo = $repository;
        $this->userRepo = $userRepo;
    }

    public function storeSystemAccess($data, $employeeId)
    {
        $data['employee_id'] = $employeeId;

        $data['full_name'] = $this->repo->getEmployeeFullName($employeeId);
        $data['email'] = $data['email'] ?? 'example@email.com';


        return $this->repo->createRecord($data) && $this->userRepo->createRecord($data);
    }

    public function getSystemAccessRecord($employeeId)
    {
        return $this->userRepo->editRecordByEmployeeId($employeeId);
    }

    public function updateSystemAccess($data, $employeeId, $id)
    {
        $data['id'] = $id;
        $data['employee_id'] = $employeeId;

        if (empty($data['password'])) {
            // password not changed → keep existing hash
            $record = $this->userRepo->editRecordByIdAndEmployeeId($id, $employeeId);
            $data['password'] = $record->password;
        } else {
            // new password provided → hash it
            $data['password'] = Hash::make($data['password']);
        }
        $userUpdated = $this->userRepo->updateRecordByIdAndEmployeeId($data, $id, $employeeId);
        $accessUpdated = $this->repo->updateSystemAccessRecord($data, $employeeId);

        // dd($data);
        // convert to boolean: 0/1 → true/false
        return ($userUpdated !== false) && ($accessUpdated !== false);
    }

}
