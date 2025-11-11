<?php

namespace App\Modules\Publication\Controllers\Admin;

use App\Core\Http\BaseCrudController;
use App\Modules\Publication\DTOs\Page\PageDto;
use App\Modules\Publication\Requests\Page\CreateUpdate;
use App\Modules\Publication\Services\Interfaces\PageServiceInterface;
use Illuminate\Http\Request;

class PageController extends BaseCrudController
{
    protected string $viewPrefix = "publication::admin.page.";
    protected string $routePrefix = 'page.';
    protected string $entityName = 'Page';
    protected $service;
    protected string $dtoClass = PageDto::class;

    public function __construct(PageServiceInterface $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $perPage = $request->input('length', config('UserManagement.user', 10));
        $serachTerm = $request->input('search');

        return $this->dataIndex($perPage, $serachTerm);
    }

    public function create()
    {
        return $this->dataCreate();
    }

    public function store(CreateUpdate $request)
    {
        return $this->dataStore($request);
    }

    public function edit($id)
    {
        return $this->dataEdit($id);
    }

    public function update(CreateUpdate $request, $id)
    {
        return $this->dataUpdate($request, $id);
    }

    public function delete($id)
    {
        return $this->dataDelete($id);
    }

    public function updateOrder(Request $request)
    {
        return $this->updateOrderInternal($request, 'pages', 'id', 'display_order');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        return $this->dataDelete($ids);
    }
}
