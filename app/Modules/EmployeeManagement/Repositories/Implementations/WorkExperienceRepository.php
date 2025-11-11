<?php

namespace App\Modules\EmployeeManagement\Repositories\Implementations;

use App\Modules\EmployeeManagement\Models\WorkExperience;
use App\Modules\EmployeeManagement\Repositories\Interfaces\WorkExperienceRepositoryInterface;
use Illuminate\Support\Facades\DB;

class WorkExperienceRepository extends BaseRepository implements WorkExperienceRepositoryInterface
{
    public function __construct(WorkExperience $model)
    {
        parent::__construct($model);
    }

    // public function getWorkList($employeeId)
    // {
    //     return DB::table('work_experiences')
    //         ->where('personal_information_id', $employeeId)
    //         ->get();
    // }

    // public function getWorkDetail($id, $employeeId)
    // {
    //     return DB::table('work_experiences')
    //         ->where('id', $id) // primary key
    //         ->where('personal_information_id', $employeeId) // foreign key
    //         ->first(); // or ->get() if you expect multiple
    // }

    // public function deleteWorkDetail($id, $employeeId)
    // {
    //     return DB::table('work_experiences')
    //         ->where('id', $id)
    //         ->where('personal_information_id', $employeeId)
    //         ->delete();
    // }

    // public function updateWorkDetail($data, $id, $employeeId)
    // {
    //     return DB::table('work_experiences')
    //         ->where('id', $id)
    //         ->where('personal_information_id', $employeeId)
    //         ->update($data);
    // }
}
