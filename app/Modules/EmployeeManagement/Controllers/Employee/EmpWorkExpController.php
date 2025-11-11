<?php

namespace App\Modules\EmployeeManagement\Controllers\Employee;

use App\Core\Http\BaseController;
use Illuminate\Http\Request;

use App\Modules\EmployeeManagement\Requests\WorkExperienceRequest;
use App\Modules\EmployeeManagement\DTOs\employee\WorkExperienceDTO;
use App\Modules\EmployeeManagement\Requests\UpdateWorkExperienceRequest;
use App\Modules\EmployeeManagement\Services\Interfaces\EmployeeServiceInterface;
use App\Modules\EmployeeManagement\Services\Interfaces\WorkExperienceServiceInterface;

class EmpWorkExpController extends BaseController
{
    protected $view = 'employeemanagement::admin.pages.employee.pages.workExperienceDetail';
    protected $workService, $empService;

    public function __construct(WorkExperienceServiceInterface $workService, EmployeeServiceInterface $empService)
    {
        $this->workService = $workService;
        $this->empService = $empService;
    }

    private function getWorkList($employeeId)
    {
        $workList = $this->workService->listRecordByEmployeeId($employeeId);
        return $workList
            ? WorkExperienceDTO::fromCollection($workList)
            : null;
    }

    public function workExperienceForm($employeeId)
    {
        if ($this->empService->checkEmployeeExist($employeeId)) {
            $data['workList'] = $this->getWorkList($employeeId);
                $data['stepCompleted'] = $this->empService->getCompletedSteps($employeeId);


        } else {
            return $this->redirectWithError('employee.create.basic', 'User Doest exist');
        }
        $data['employeeId'] = $employeeId;
        return view($this->view, ['data' => $data]);
    }

    // work crud
    public function storeWorkDetail(WorkExperienceRequest $request, $employeeId)
    {
        $dto = WorkExperienceDTO::fromData($request->validated())->toArray();
        $result = $this->workService->createWorkDetail($dto, $employeeId);
        return $result
            ? $this->redirectBackWithSuccess('Data Created Successfully')
            : $this->redirectBackWithErrorMessage('Failed to Create New Data');
    }

    public function deleteworkDetail($employeeId, $id)
    {
        $result = $this->workService->deleteworkDetail($id, $employeeId);
        return $result
            ? $this->redirectBackWithSuccess('Data Deleted Successfully')
            : $this->redirectBackWithErrorMessage('Failed to Delete Data');
    }

    public function editWorkDetail($employeeId, $id)
    {
        $editRecord = $this->workService->editRecordByIdAndEmployeeId($id, $employeeId);
        if ($editRecord) {
            $data['workDetail'] = WorkExperienceDTO::fromDB($editRecord)->toArray();
            $data['employeeId'] = $employeeId;
            $data['workList'] = $this->getWorkList($employeeId);
                $data['stepCompleted'] = $this->empService->getCompletedSteps($employeeId);

            return view($this->view , ['data' => $data]);
        } else {
            return $this->redirectBackWithErrorMessage('Data not found');
        }
    }

    public function updateworkDetail(UpdateWorkExperienceRequest $request, $employeeId, $id)
    {
        $dto = WorkExperienceDTO::fromData($request->validated());
        $result = $this->workService->updateWorkDetail($dto->toArray(), $id, $employeeId);
        return $result
            ? $this->redirectBackWithSuccess('Data updated successfully')
            : $this->redirectBackWithErrorMessage('Failed to update data');
    }
}
