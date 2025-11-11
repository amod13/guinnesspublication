<?php

namespace App\Modules\EmployeeManagement\Controllers;

use App\Core\Http\BaseController;
use App\Modules\EmployeeManagement\DTOs\DesignationDTO;
use App\Modules\EmployeeManagement\Requests\DesignationRequest;
use App\Modules\EmployeeManagement\Services\Interfaces\DesignationServiceInterface;
use Illuminate\Http\Request;

class DesignationController extends BaseController
{
    protected $view = 'employeemanagement::admin.pages.designation.';
    protected $designationService;

    public function __construct(DesignationServiceInterface $designationService)
    {
        $this->designationService = $designationService;
    }

    public function index(Request $request)
    {
        $query = $request->input('search') ?? '';
        $perPage = $request->input('perPage') ?? 2;
        $data['records'] = $this->designationService->getPaginatedData($perPage, $query);
        return view($this->view . 'index', [
            'data' => $data
        ]);
    }

    public function create()
    {
        return view($this->view . 'create');
    }

    public function store(DesignationRequest $request)
    {
        $result = $this->designationService->createWithOrder($request->validated());
        return $result
            ? $this->redirectWithSuccess("designation.index", "Data Created Successfully")
            : $this->redirectWithError('designation.create', 'Unable To Create');
    }

    public function edit($id)
    {
        $data['record'] = DesignationDTO::fromData($this->designationService->editRecord($id));
        return view($this->view . 'edit', [
            'data' => $data,
        ]);
    }

    public function update(DesignationRequest $request, $id)
    {
        $result = $this->designationService->updateRecord($id, $request->validated());
        return $result
            ? $this->redirectWithSuccess('designation.index', 'Successfully Updated')
            : $this->redirectBackWithErrorMessage('Unable to Update');
    }

    public function delete($id)
    {
        $result = $this->designationService->deleteRecord($id);
        return $result
            ? $this->redirectBackWithSuccess('deleted successfully')
            : $this->redirectBackWithErrorMessage('unable to delete');
    }
}
