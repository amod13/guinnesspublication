<?php

namespace App\Modules\Publication\Controllers\Admin;

use App\Core\Http\BaseCrudController;
use App\Modules\Publication\DTOs\Dealers\DealersDto;
use App\Modules\Publication\Requests\DealerCreateUpdate;
use App\Modules\Publication\Services\Interfaces\DealersServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DealersController extends BaseCrudController
{
    protected string $viewPrefix = "publication::admin.dealers.";
    protected string $routePrefix = 'dealers.';
    protected string $entityName = 'Dealers';
    protected string $dtoClass = DealersDto::class;

    public function __construct(DealersServiceInterface $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $perPage = $request->input('length', 10);
        $searchTerm = $request->all();

        return $this->dataIndex($perPage, $searchTerm);
    }

    public function create()
    {
        return $this->dataCreate();
    }

    public function store(DealerCreateUpdate $request)
    {
        try {
            $data = $request->all();
            $record = $this->service->createRecord($data);
            return redirect()->route($this->routePrefix . 'index')
                ->with('success', $this->entityName . ' created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create ' . $this->entityName . ': ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        return $this->dataShow($id);
    }

    public function edit($id)
    {
        try {
            $record = $this->service->findById($id);
            $user = DB::table('users')->where('email', $record->email)->first();
            
            $data = [
                'record' => $record,
                'user' => $user
            ];
            
            return view($this->viewPrefix . 'create', compact('data'));
        } catch (\Exception $e) {
            return redirect()->route($this->routePrefix . 'index')
                ->with('error', 'Failed to load ' . $this->entityName . ': ' . $e->getMessage());
        }
    }

    public function update(DealerCreateUpdate $request, $id)
    {
        try {
            $data = $request->all();
            $record = $this->service->updateRecord($data, $id);
            return redirect()->route($this->routePrefix . 'index')
                ->with('success', $this->entityName . ' updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update ' . $this->entityName . ': ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        return $this->dataDelete($id);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        return $this->dataDelete($ids);
    }

    public function updateOrder(Request $request)
    {
        return $this->updateOrderInternal($request, 'dealers', 'id', 'display_order');
    }
}