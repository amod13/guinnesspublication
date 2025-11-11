<?php

namespace App\Modules\EmployeeManagement\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\EmployeeManagement\Enums\BloodGroupEnum;
use App\Modules\EmployeeManagement\Enums\EmploymentTypeEnum;
use App\Modules\EmployeeManagement\Enums\GenderEnum;
use App\Modules\EmployeeManagement\Enums\JobCategoryEnum;
use App\Modules\EmployeeManagement\Enums\MaritalStatusEnum;
use App\Modules\EmployeeManagement\Enums\RelationshipEnum;
use App\Modules\EmployeeManagement\Enums\StatusEnum;
use App\Modules\EmployeeManagement\DTOs\DepartmentDTO;
use App\Modules\EmployeeManagement\DTOs\DesignationDTO;
use App\Modules\EmployeeManagement\Services\Interfaces\DepartmentServiceInterface;
use App\Modules\EmployeeManagement\Services\Interfaces\DesignationServiceInterface;
use App\Modules\EmployeeManagement\Services\Interfaces\EmployeeServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;


class EmployeeController extends Controller
{
    protected $view = 'employeemanagement::admin.pages.employee.';
    protected $employeeService, $deptService, $designationService;


    public function __construct(
        EmployeeServiceInterface $employeeService,
        DepartmentServiceInterface $deptService,
        DesignationServiceInterface $designationService,
    ) {
        $this->employeeService = $employeeService;
        $this->deptService = $deptService;
        $this->designationService = $designationService;
    }


    // main page
    public function index(Request $request)
    {
        $data = $this->dataPrepareForView(['department', 'designation', 'status', 'jobCategory', 'employmentType']); // drop down menu

        $searchField = $request->all();
        $perPage = $request->input('perPage') ?? 5;

        $data['records'] = $this->employeeService->searchEmployee($searchField, $perPage);
        $data['selectedSearchField'] = $searchField;

        return view($this->view . 'index', ['data' => $data]);
    }


    // employeeDetail page
    public function employeeDetail($id)
    {
        $isDataFiled = $this->employeeService->getCompletedSteps($id);
        //       false -> we look false in isDataField | true -> must be true not 1.
        if (in_array(false, $isDataFiled, true)) {
            return redirect()->back()->with('error', 'Please complete all steps before accessing employee details.');
        }
        // If all steps are completed, proceed
        $data = $this->employeeService->getEmployeeDetail($id);

        return view($this->view . 'employeeDetail', ['data' => $data]);
    }


    // data preparing for view
    private function dataPrepareForView(array $only = [])
    {
        $data = [
            'employmentType' => EmploymentTypeEnum::options(),
            'jobCategory' => JobCategoryEnum::options(),
            'status' => StatusEnum::options(),
            'department' => DepartmentDTO::getIdAndName($this->deptService->getActiveRecord()),
            'designation' => DesignationDTO::getIdAndName($this->designationService->getActiveRecord()),
        ];
        return $only ? Arr::only($data, $only) : $data;
    }
}
