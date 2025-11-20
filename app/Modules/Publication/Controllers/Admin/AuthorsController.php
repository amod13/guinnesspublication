<?php

namespace App\Modules\Publication\Controllers\Admin;

use App\Core\Http\BaseCrudController;
use App\Modules\Publication\DTOs\Authors\AuthorsDto;
use App\Modules\Publication\Requests\AuthorCreateUpdate;
use App\Modules\Publication\Services\Interfaces\AuthorsServiceInterface;
use Illuminate\Http\Request;

class AuthorsController extends BaseCrudController
{
    protected string $viewPrefix = "publication::admin.authors.";
    protected string $routePrefix = 'authors.';
    protected string $entityName = 'Authors';
    protected string $dtoClass = AuthorsDto::class;

    public function __construct(AuthorsServiceInterface $service)
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

    public function store(AuthorCreateUpdate $request)
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

    public function update(AuthorCreateUpdate $request, $id)
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
        return $this->updateOrderInternal($request, 'authors', 'id', 'display_order');
    }
}
