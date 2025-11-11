<?php

namespace App\Modules\EmployeeManagement\Controllers\Employee;

use App\Core\Http\BaseController;
use Illuminate\Http\Request;

use App\Modules\EmployeeManagement\DTOs\employee\OfficialDocumentDTO;
use App\Modules\EmployeeManagement\Requests\OfficialDocumentRequest;
use App\Modules\EmployeeManagement\Services\Interfaces\EmployeeServiceInterface;
use App\Modules\EmployeeManagement\Services\Interfaces\OfficialDocumentServiceInterface;

class EmpDocumentController extends BaseController
{
    protected $view = 'employeemanagement::admin.pages.employee.pages.documentDetail';
    protected $documentService, $empService;

    public function __construct(OfficialDocumentServiceInterface $documentService, EmployeeServiceInterface $empService)
    {
        $this->documentService = $documentService;
        $this->empService = $empService;
    }

    private function getDocumentList($employeeId)
    {
        $data = $this->documentService->editRecordByEmployeeId($employeeId);
        return $data
            ? OfficialDocumentDTO::editDocumentFromDB($data)->toArray()
            : null;
    }

    public function documentDetailForm($employeeId)
    {
        if ($this->empService->checkEmployeeExist($employeeId)) {
            $data['documentDetail'] = $this->getDocumentList($employeeId);
                $data['stepCompleted'] = $this->empService->getCompletedSteps($employeeId);

        } else {
            return $this->redirectWithError('employee.create.basic', 'User Doest exist');
        }
        $data['employeeId'] = $employeeId;

        return view($this->view, ['data' => $data]);
    }

    // official docuemnet
    public function storeDocumentDetail(OfficialDocumentRequest $request, $employeeId)
    {
        $result = $this->documentService->storeOfficalDocument($request->validated(), $employeeId);

        return $result
            ? $this->redirectBackWithSuccess('Data Created Successfully')
            : $this->redirectBackWithErrorMessage('Failed to Create New Data');
    }

    public function updateDocumentDetail(OfficialDocumentRequest $request, $employeeId, $id)
    {
        $result = $this->documentService->updateDocumentDetail($request->validated(), $id, $employeeId);

        return $result
            ? $this->redirectBackWithSuccess('Data Deleted updated successfully')
            : $this->redirectBackWithErrorMessage('Failed to update data');
    }
}
