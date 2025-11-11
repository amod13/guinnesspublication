<?php

namespace App\Modules\EmployeeManagement\Controllers\Employee;

use App\Core\Http\BaseController;
use Illuminate\Http\Request;

use App\Modules\EmployeeManagement\Requests\SystemAccessRequest;
use App\Modules\EmployeeManagement\DTOs\employee\SystemAccessDTO;
use App\Modules\EmployeeManagement\Enums\StatusEnum;
use App\Modules\EmployeeManagement\Requests\UpdateSystemAccessRequest;
use App\Modules\EmployeeManagement\Services\Interfaces\EmployeeServiceInterface;
use App\Modules\EmployeeManagement\Services\Interfaces\SystemAccessServiceInterface;
use App\Modules\UserManagement\Repositories\Implementations\RoleRepository;

class EmpSystemAccessController extends BaseController
{
    protected $view = 'employeemanagement::admin.pages.employee.pages.systemAccess';
    protected $systemAccessService, $empService,$roleService;
    public function __construct(SystemAccessServiceInterface $systemAccessService, EmployeeServiceInterface $empService,RoleRepository $roleService)
    {
        $this->systemAccessService = $systemAccessService;
        $this->empService = $empService;
        $this->roleService = $roleService;
    }

    public function systemAccessFrom(int $employeeId)
    {
        if ($this->empService->checkEmployeeExist($employeeId)) {

            $data = $this->systemAccessService->getSystemAccessRecord($employeeId);

            if ($data) {
                $data['systemAccessDetail'] = SystemAccessDTO::editDetail($data);
            }
            $data['stepCompleted'] = $this->empService->getCompletedSteps($employeeId);
        } else {
            return $this->redirectWithError('employee.create.basic', 'User Doest exist');
        }
        $data['employeeId'] = $employeeId;
        $data['status'] = StatusEnum::options();
        $data['roles'] = $this->roleService->getRolesExcludingSuperadmin();

        // dd( $data['systemAccessDetail']['role_id']);

        return view($this->view, ['data' => $data]);
    }

    // system access
    public function storeSystemAccessDetail(SystemAccessRequest $request, $employeeId)
    {
        $dto = SystemAccessDTO::fromData($request->validated())->toArray();

        $result = $this->systemAccessService->storeSystemAccess($dto, $employeeId);

        return $result
            ? $this->redirectBackWithSuccess('Data Created Successfully')
            : $this->redirectBackWithErrorMessage('Failed to Create New Data');
    }


    public function updateSystemAccessDetail(UpdateSystemAccessRequest $request, $employeeId, $id)
    {
        $dto = SystemAccessDTO::fromData($request->validated())->toArray();

        $result = $this->systemAccessService->updateSystemAccess($dto, $employeeId, $id);


        return $result
            ? $this->redirectBackWithSuccess('Data updated successfully')
            : $this->redirectBackWithErrorMessage('Failed to update data');
    }
}
