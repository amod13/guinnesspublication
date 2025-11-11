<?php

namespace App\Modules\Publication\Controllers\Admin;

use App\Core\Http\BaseCrudController;
use App\Modules\Publication\DTOs\BookCategories\BookCategoriesDto;
use App\Modules\Publication\Requests\BookCategoriesRequest;
use App\Modules\Publication\Services\Interfaces\BookCategoriesServiceInterface;
use Illuminate\Http\Request;

class BookCategoriesController extends BaseCrudController
{
    protected string $viewPrefix = "publication::admin.bookcategories.";
    protected string $routePrefix = 'bookcategories.';
    protected string $entityName = 'BookCategories';
    protected string $dtoClass = BookCategoriesDto::class;

    public function __construct(BookCategoriesServiceInterface $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $perPage = $request->input('length', 10);
        $searchTerm = $request->input('search');

        return $this->dataIndex($perPage, $searchTerm);
    }

    public function create()
    {
        return $this->dataCreate();
    }

    public function store(BookCategoriesRequest $request)
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

    public function update(BookCategoriesRequest $request, $id)
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
        return $this->updateOrderInternal($request, 'book_categories', 'id', 'display_order');
    }
}
