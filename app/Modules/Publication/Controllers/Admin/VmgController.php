<?php

namespace App\Modules\Publication\Controllers\Admin;

use App\Core\Http\BaseCrudController;
use App\Modules\Publication\DTOs\Vmg\VmgDto;
use App\Modules\Publication\Requests\VMGCreateUpdateRequest;
use App\Modules\Publication\Services\Interfaces\VmgServiceInterface;
use Illuminate\Http\Request;

class VmgController extends BaseCrudController
{
    protected string $viewPrefix = "publication::admin.vmg.";
    protected string $routePrefix = 'vmg.';
    protected string $entityName = 'VMG';

    protected $service, $selectOptionMapper;
    protected string $dtoClass = VmgDto::class;
    
    public function __construct(VmgServiceInterface $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $perPage = $request->input('length', 10);
        $serachTerm = $request->input('search');

        return $this->dataIndex($perPage, $serachTerm);
    }

    public function create()
    {
        return $this->dataCreate();
    }

    public function store(VMGCreateUpdateRequest $request)
    {
        return $this->dataStore($request);
    }

    public function edit($id)
    {
        return $this->dataEdit($id);
    }

    public function update(VMGCreateUpdateRequest $request, $id)
    {
        return $this->dataUpdate($request, $id);
    }

    public function delete($id)
    {
        return $this->dataDelete($id);
    }

    public function updateOrder(Request $request)
    {
        return $this->updateOrderInternal($request, 'vmgs', 'id', 'display_order');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        return $this->dataDelete($ids);
    }
}
