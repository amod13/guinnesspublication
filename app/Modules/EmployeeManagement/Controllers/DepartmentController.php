<?php

namespace App\Modules\EmployeeManagement\Controllers;

use App\Core\Http\BaseController;
use App\Modules\EmployeeManagement\DTOs\DepartmentDTO;
use App\Modules\EmployeeManagement\Requests\DepartmentRequest;
use App\Modules\EmployeeManagement\Services\Interfaces\DepartmentServiceInterface;
use Illuminate\Http\Request;

class DepartmentController extends BaseController
{
    protected $view = 'employeemanagement::admin.pages.department.';
    protected $departService;

    public function __construct(DepartmentServiceInterface $departService)
    {
        $this->departService = $departService;
    }

    public function index(Request $request)
    {
        $query = $request->input('search') ?? '';
        $perPage = $request->input('perPage') ?? 2;
        $data['records'] = $this->departService->getPaginatedData($perPage, $query);

        return view($this->view . 'index', [
            'data' => $data
        ]);
    }

    public function create()
    {
        return view($this->view . 'create');
    }

    public function store(DepartmentRequest $request)
    {
        $result = $this->departService->createWithOrder($request->validated());
        return $result
            ? $this->redirectWithSuccess('department.index', 'Data Dreated successfully')
            : $this->redirectWithError("department.create", 'Failed to create');
    }

    public function edit($id)
    {
        $data['record'] = DepartmentDTO::fromData($this->departService->editRecord($id));
        return view($this->view . 'edit', [
            'data' => $data,
        ]);
    }

    public function update(DepartmentRequest $request, $id)
    {
        $result = $this->departService->updateRecord($id, $request->validated());
        return $result
            ? $this->redirectWithSuccess("department.index", "Successfully Updated")
            : $this->redirectBackWithErrorMessage("Unable to update");

    }

    public function delete($id)
    {
        $result = $this->departService->deleteRecord($id);

        return $result
            ? $this->redirectBackWithSuccess('deleted successfully')
            : $this->redirectBackWithErrorMessage('unable to delete');
    }
}
