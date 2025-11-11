<?php

namespace App\Modules\EmployeeManagement\Controllers;

use App\Core\Http\BaseController;
use App\Modules\EmployeeManagement\DTOs\DepartmentDTO;
use App\Modules\EmployeeManagement\DTOs\SubDepartmentDTO;
use App\Modules\EmployeeManagement\Requests\SubDepartmentRequest;
use App\Modules\EmployeeManagement\Services\Interfaces\DepartmentServiceInterface;
use App\Modules\EmployeeManagement\Services\Interfaces\SubDepartmentServiceInterface;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SubDepartmentController extends BaseController
{
    protected $view = 'employeemanagement::admin.pages.subdepartment.';
    protected $subDeptService, $deptService;

    public function __construct(
        SubDepartmentServiceInterface $subDeptService,
        DepartmentServiceInterface $deptService
    ) {
        $this->subDeptService = $subDeptService;
        $this->deptService = $deptService;
    }

    public function index(Request $request)
    {
        $query = $request->input('search') ?? '';
        $perPage = $request->input('perPage') ?? 2;
        $data['records'] = $this->subDeptService->getPaginatedData($perPage, $query);
        return view($this->view . 'index', [
            'data' => $data
        ]);
    }

    public function create()
    {
        $data['dept'] = DepartmentDTO::getIdAndName($this->deptService->getActiveRecord());
        return view($this->view . 'create', ['data' => $data]);
    }

    public function store(SubDepartmentRequest $request)
    {
        $result = $this->subDeptService->createWithOrder($request->validated());
        return $result
            ? $this->redirectWithSuccess("subdepartment.index", "Data Created Successfully")
            : $this->redirectWithError("subdepartment.create", "Unable to create");
    }

    public function edit($id)
    {
        $data['dept'] = DepartmentDTO::getIdAndName($this->deptService->getAll());
        $data['record'] = SubDepartmentDTO::fromData($this->subDeptService->editRecord($id));
        return view($this->view . 'edit', [
            'data' => $data,
        ]);
    }

    public function update(SubDepartmentRequest $request, $id)
    {
        $result = $this->subDeptService->updateRecord($id, $request->validated());
        return $result
            ? $this->redirectWithSuccess("subdepartment.index", "Successfully Updated")
            : $this->redirectBackWithErrorMessage("Unable to Update");
    }

    public function delete($id)
    {
        $result = $this->subDeptService->deleteRecord($id);

        return $result
            ? $this->redirectBackWithSuccess('deleted successfully')
            : $this->redirectBackWithErrorMessage('unable to delete');
    }

    public function getSubdeptIdAndName($deptId)
    {
        return SubDepartmentDTO::getIdAndName($this->subDeptService->getByDepartmentId($deptId));
    }

    public function getSubDeptJson(Request $request)
    {
        $deptId = $request->input('deptId');

        $data = SubDepartmentDTO::getIdAndName($this->subDeptService->getByDepartmentId($deptId));

        return response()->json($data);
    }
}
