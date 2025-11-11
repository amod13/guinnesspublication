<?php

namespace App\Modules\EmployeeManagement\Controllers\Employee;

use App\Core\Http\BaseController;
use App\Modules\EmployeeManagement\Requests\BankDetailRequest;
use App\Modules\EmployeeManagement\DTOs\employee\BankDetailDTO;
use App\Modules\EmployeeManagement\Enums\StatusEnum;
use App\Modules\EmployeeManagement\Requests\UpdateBankDetailRequest;
use App\Modules\EmployeeManagement\Services\Interfaces\BankDetailServiceInterface;
use App\Modules\EmployeeManagement\Services\Interfaces\EmployeeServiceInterface;


class EmpBankDetailController extends BaseController
{
    protected $view = 'employeemanagement::admin.pages.employee.pages.bankDetail';
    protected $bankService, $empService;

    public function __construct(BankDetailServiceInterface $bankService, EmployeeServiceInterface $empService)
    {
        $this->bankService = $bankService;
        $this->empService = $empService;
    }
    private function getBankList($employeeId)
    {
        $data = $this->bankService->listRecordByEmployeeId($employeeId);
        return $data
            ? BankDetailDTO::fromCollection($data)
            : null;
    }

    public function bankDetailFrom($employeeId)
    {
        if ($this->empService->checkEmployeeExist($employeeId)) {
            $data['status'] = StatusEnum::options();
            $data['bankList'] = $this->getBankList($employeeId);
                $data['stepCompleted'] = $this->empService->getCompletedSteps($employeeId);

        } else {
            return $this->redirectWithError('employee.create.basic', 'User Doest exist');
        }
        $data['employeeId'] = $employeeId;
        return view($this->view, ['data' => $data]);
    }


    // bank detail
    public function storeBankDetail(BankDetailRequest $request, $employeeId)
    {
        $dto = BankDetailDTO::fromData($request->validated())->toArray();
        $dto['employee_id'] = $employeeId;
        $result = $this->bankService->createRecord($dto);

        return $result
            ? $this->redirectBackWithSuccess('Data Created Successfully')
            : $this->redirectBackWithErrorMessage('Failed to Create New Data');
    }


    public function editBankDetail($employeeId, $id)
    {
        $editRecord = $this->bankService->editRecordByIdAndEmployeeId($id, $employeeId);
        if ($editRecord) {
            $data['bankDetail'] = BankDetailDTO::editData($editRecord)->toArray();
            $data['employeeId'] = $employeeId;
            $data['bankList'] = $this->getBankList($employeeId);
            $data['status']  = StatusEnum::options();
                $data['stepCompleted'] = $this->empService->getCompletedSteps($employeeId);

            return view($this->view, ['data' => $data]);
        } else {
            return $this->redirectBackWithErrorMessage('Data not found');
        }
    }


    public function deleteBankDetail($employeeId, $id)
    {
        $result = $this->bankService->deleteRecordByIdAndEmployeeId($id, $employeeId);

        return $result
            ? $this->redirectBackWithSuccess('Data deleted Successfully')
            : $this->redirectBackWithErrorMessage('Failed to delete data');
    }


    public function updateBankDetail(UpdateBankDetailRequest $request, $id, $employeeId)
    {
        $dto = BankDetailDTO::fromData($request->all())->toArray();
        $dto['id'] = $id;
        $dto['employee_id'] = $employeeId;
        $result = $this->bankService->updateRecordByIdAndEmployeeId($dto, $id, $employeeId);

        return $result
            ? $this->redirectBackWithSuccess('Successfully updated')
            : $this->redirectBackWithErrorMessage('Failed to Update data');
    }
}
