<?php

namespace App\Modules\Publication\Controllers\Admin;

use App\Core\Http\BaseCrudController;
use App\Modules\Publication\DTOs\Marketings\MarketingsDto;
use App\Modules\Publication\Requests\MarketingsRequest;
use App\Modules\Publication\Services\Interfaces\MarketingsServiceInterface;
use Illuminate\Http\Request;

class MarketingsController extends BaseCrudController
{
    protected string $viewPrefix = "publication::admin.marketings.";
    protected string $routePrefix = 'marketings.';
    protected string $entityName = 'Marketings';
    protected string $dtoClass = MarketingsDto::class;

    public function __construct(MarketingsServiceInterface $service)
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

    public function store(MarketingsRequest $request)
    {
        return $this->dataStore($request);
    }

    public function show($id)
    {
        return $this->dataShow($id);
    }

    public function edit($id)
    {
        return $this->dataEdit($id);
    }

    public function update(MarketingsRequest $request, $id)
    {
        return $this->dataUpdate($request, $id);
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
        return $this->updateOrderInternal($request, 'marketings', 'id', 'display_order');
    }
}
