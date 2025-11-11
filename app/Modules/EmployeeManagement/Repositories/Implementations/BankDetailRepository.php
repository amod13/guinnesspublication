<?php

namespace App\Modules\EmployeeManagement\Repositories\Implementations;

use App\Modules\EmployeeManagement\Models\SalaryDetails;
use App\Modules\EmployeeManagement\Repositories\Interfaces\BankDetailRepositoryInterface;
use Illuminate\Support\Facades\DB;

class BankDetailRepository extends BaseRepository implements BankDetailRepositoryInterface
{
    public function __construct(SalaryDetails $model) {
        parent::__construct($model);
    }

    public function getBankDetail($employeeId)
    {
        return DB::table('emp_salary_details')
            ->where('employee_id', $employeeId)
            ->get();
    }
}
