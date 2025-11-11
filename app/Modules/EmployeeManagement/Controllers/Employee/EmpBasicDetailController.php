<?php

namespace App\Modules\EmployeeManagement\Controllers\Employee;

use App\Core\Http\BaseController;
use Illuminate\Support\Arr;
use App\Modules\EmployeeManagement\Enums\GenderEnum;
use App\Modules\EmployeeManagement\Enums\StatusEnum;
use App\Modules\EmployeeManagement\DTOs\DepartmentDTO;
use App\Modules\EmployeeManagement\DTOs\DesignationDTO;
use App\Modules\EmployeeManagement\Enums\BloodGroupEnum;
use App\Modules\EmployeeManagement\Enums\JobCategoryEnum;
use App\Modules\EmployeeManagement\Enums\RelationshipEnum;
use App\Modules\EmployeeManagement\Enums\MaritalStatusEnum;
use App\Modules\EmployeeManagement\Enums\EmployeeStatusEnum;
use App\Modules\EmployeeManagement\Enums\EmploymentTypeEnum;
use App\Modules\EmployeeManagement\Requests\StoreBasicInfoRequest;
use App\Modules\EmployeeManagement\Requests\UpdateBasicInfoRequest;
use App\Modules\EmployeeManagement\Services\Interfaces\EmployeeServiceInterface;
use App\Modules\EmployeeManagement\Services\Interfaces\DepartmentServiceInterface;
use App\Modules\EmployeeManagement\Services\Interfaces\DesignationServiceInterface;
use Illuminate\Http\Request;

class EmpBasicDetailController extends BaseController
{
    protected $empService, $deptService, $designationService;
    protected $view = 'employeemanagement::admin.pages.employee.pages.basicDetail';

    public function __construct(
        EmployeeServiceInterface $empService,
        DepartmentServiceInterface $deptService,
        DesignationServiceInterface $designationService
    ) {
        $this->empService = $empService;
        $this->deptService = $deptService;
        $this->designationService = $designationService;
    }


    public function personalDetailForm(?int $employeeId = null)
    {
        $data = $this->dataPrepareForView();

        if ($employeeId && $this->empService->checkEmployeeExist($employeeId)) // Edit mode only if employeeId is given and exists
        {
            $info = $this->empService->getBasicEmployeeDetail($employeeId);

            if ($info) {
                $data = array_merge($data, $info);
            }

            $data['employeeId'] = $employeeId;
            $data['stepCompleted'] = $this->empService->getCompletedSteps($employeeId);
        } else // Create Mode
        {
            $data['employeeId'] = null;
        }

        return view($this->view, ['data' => $data]);
    }


    // basic table first phase
    public function storeBasicInfo(StoreBasicInfoRequest $request)
    {
        $employeeId = $this->empService->storeBasicEmployeeDetail($request->validated());
        return $employeeId
            ? redirect()->route('employee.create.education', ['employeeId' => $employeeId])->with('success', 'Data Uploaded Successfully')
            : $this->redirectBackWithErrorMessage('Failed to save data');
    }

    public function updateBasicInfo(UpdateBasicInfoRequest $request, $employeeId)
    {
        // dd('ok');
        $employeeId = $this->empService->updateBasicInfo($request->validated(), $employeeId);
        return $employeeId
            ? $this->redirectBackWithSuccess('Successfully Updated')
            : $this->redirectBackWithErrorMessage('Unable to Update');
    }


    // data preparing for view
    private function dataPrepareForView(array $only = [])
    {
        $data = [
            'gender' => GenderEnum::options(),
            'maritalStatus' => MaritalStatusEnum::options(),
            'bloodGroup' => BloodGroupEnum::options(),
            'relationship' => RelationshipEnum::options(),
            'employmentType' => EmploymentTypeEnum::options(),
            'jobCategory' => JobCategoryEnum::options(),
            'employeeStatus' => EmployeeStatusEnum::options(), //
            'status' => StatusEnum::options(),
            'department' => DepartmentDTO::getIdAndName($this->deptService->getActiveRecord()),
            'designation' => DesignationDTO::getIdAndName($this->designationService->getActiveRecord()),
        ];
        return $only ? Arr::only($data, $only) : $data;
    }
}
