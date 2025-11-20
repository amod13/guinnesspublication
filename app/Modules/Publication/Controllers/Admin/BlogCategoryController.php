<?php

namespace App\Modules\Publication\Controllers\Admin;

use App\Core\Http\BaseCrudController;
use App\Modules\Publication\DTOs\BlogCategory\BlogCategoryDto;
use App\Modules\Publication\Requests\BlogCategoryCreateUpdate;
use App\Modules\Publication\Services\Interfaces\BlogCategoryServiceInterface;
use Illuminate\Http\Request;

class BlogCategoryController extends BaseCrudController
{
    protected string $viewPrefix = "publication::admin.blogCategory.";
    protected string $routePrefix = 'blog-category.';
    protected string $entityName = 'Blog Category';

    protected $service, $selectOptionMapper;
    protected string $dtoClass = BlogCategoryDto::class;

    public function __construct(BlogCategoryServiceInterface $service)
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
        $parentCategories = $this->service->getActiveBlogCategories();
        return $this->dataCreate(['parentCategories' => $parentCategories]);
    }

    public function store(BlogCategoryCreateUpdate $request)
    {
        return $this->dataStore($request);
    }

    public function edit($id)
    {
        $parentCategories = $this->service->getActiveBlogCategories();
        return $this->dataEdit($id, ['parentCategories' => $parentCategories]);
    }

    public function update(BlogCategoryCreateUpdate $request, $id)
    {
        return $this->dataUpdate($request, $id);
    }

    public function delete($id)
    {
        return $this->dataDelete($id);
    }

    public function updateOrder(Request $request)
    {
        return $this->updateOrderInternal($request, 'blog_categories', 'id', 'display_order');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        return $this->dataDelete($ids);
    }
}
