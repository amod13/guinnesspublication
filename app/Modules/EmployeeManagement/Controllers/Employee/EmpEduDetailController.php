<?php

namespace App\Modules\EmployeeManagement\Controllers\Employee;

use App\Core\Http\BaseController;
use Illuminate\Http\Request;

use App\Modules\EmployeeManagement\Requests\EducationRequest;
use App\Modules\EmployeeManagement\DTOs\employee\EducationDTO;
use App\Modules\EmployeeManagement\Requests\UpdateEducationRequest;
use App\Modules\EmployeeManagement\Services\Interfaces\EducationServiceInterface;
use App\Modules\EmployeeManagement\Services\Interfaces\EmployeeServiceInterface;

class EmpEduDetailController extends BaseController
{
    protected $view = 'employeemanagement::admin.pages.employee.pages.educationDetail';
    protected $eduService, $empService;

    public function __construct(EducationServiceInterface $eduService, EmployeeServiceInterface $empService)
    {
        $this->eduService = $eduService;
        $this->empService = $empService;
    }


    // we use one form for 2 case create && edit
    public function educationFrom(int $employeeId)
    {
        if ($this->empService->checkEmployeeExist($employeeId)) // first check if first phase is complete
        {
            $eduList =  $this->getEducationList($employeeId);
            // get edu list for that user;
            if ($eduList) // data is present SO it is edit mode
            {
                $data['eduList'] =  $eduList;
            } // not present edu list
            $data['stepCompleted'] = $this->empService->getCompletedSteps($employeeId);
        } else // employee doesnot exist.
        {
            return $this->redirectWithError('employee.create.basic', 'User Doest exist');
        }

        $data['employeeId'] = $employeeId; // Create Mode

        return view($this->view, ['data' => $data]);
    }

    private function getEducationList($employeeId)
    {
        $eduList = $this->eduService->listRecordByEmployeeId($employeeId);
        return $eduList
            ? EducationDTO::fromCollection($eduList)
            : null;
    }

    public function editEducationDetail($employeeId, $eduId)
    {
        $editRecord = $this->eduService->editRecordByIdAndEmployeeId($eduId, $employeeId);

        if ($editRecord) {
            $data['educationDetail'] = EducationDTO::fromDB($editRecord)->toArray();
            $data['employeeId'] = $employeeId;
            $data['eduList'] = $this->getEducationList($employeeId);
            $data['stepCompleted'] = $this->empService->getCompletedSteps($employeeId);

            return view($this->view, ['data' => $data]);
        } else {
            return $this->redirectBackWithErrorMessage('Data not found');
        }
    }


    // education crud
    public function storeEducationDetail(EducationRequest $request, $employeeId)
    {
        $dto = EducationDTO::fromData($request->validated());
        $result = $this->eduService->storeEducation($dto->toArray(), $employeeId);

        return $result
            ? $this->redirectBackWithSuccess('Data Created Successfully')
            : $this->redirectBackWithErrorMessage('Failed to Create New Data');
    }


    public function updateEducationDetail(UpdateEducationRequest $request, $employeeId, $eduId)
    {
        $result = $this->eduService->updateEducationDetail($request->validated(), $eduId, $employeeId);

        return $result
            ? $this->redirectBackWithSuccess('Updated Successfully')
            : $this->redirectBackWithErrorMessage('Failed To Update');
    }


    public function deleteEducationDetail($employeeId, $eduId)
    {
        $result = $this->eduService->deleteEducationDetail($eduId, $employeeId);

        return $result
            ? $this->redirectBackWithSuccess('Data Deleted Successfully')
            : $this->redirectBackWithErrorMessage('Unable To Delete Data');
    }
}
