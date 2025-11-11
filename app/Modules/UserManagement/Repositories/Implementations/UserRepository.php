<?php

namespace App\Modules\UserManagement\Repositories\Implementations;

use App\Core\Repositories\Implementation\BaseRepository;
use App\Modules\UserManagement\Models\User;
use App\Modules\UserManagement\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    protected $model;
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function getUsers()
    {
        $users = DB::table('users')
            ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
            ->select('users.id', 'users.name', 'users.last_login', 'users.email', 'users.status', 'roles.name as role_name')
            ->get();
        return $users;
    }

    public function keepLastLogin($userId)
    {
        DB::table('users')->where('id', $userId)->update(['last_login' => now()]);
    }
    public function editRecordByIdAndEmployeeId($id, $employeeId)
    {
        return $this->model::where('id', $id)
            ->where('employee_id', $employeeId)
            ->first();
    }
    public function updateRecordByIdAndEmployeeId($data, $id, $employeeId)
    {
        return $this->model::where('id', $id)
            ->where('employee_id', $employeeId)
            ->update($data);
    }

    public function editRecordByEmployeeId($employeeId)
    {
        return $this->model::where('employee_id', $employeeId)
            ->first();
    }
}
