<?php

namespace App\Modules\Publication\Controllers\Admin;

use App\Core\Http\BaseCrudController;

use App\Modules\Publication\DTOs\Blog\BlogDto;
use App\Modules\Publication\DTOs\BlogCategory\BlogCategoryDto;
use App\Modules\Publication\Requests\BlogCreateUpdate;
use App\Modules\Publication\Services\Interfaces\BlogCategoryServiceInterface;
use App\Modules\Publication\Services\Interfaces\BlogServiceInterface;
use Illuminate\Http\Request;

class BlogController extends BaseCrudController
{
    protected string $viewPrefix = "publication::admin.blog.";
    protected string $routePrefix = 'blog.';
    protected string $entityName = 'Blog';
    protected $service,$blogCategoryService;
    protected string $dtoClass = BlogDto::class;

    public function __construct(
        BlogServiceInterface $service,
        BlogCategoryServiceInterface $blogCategoryService,
    ) {
        $this->service = $service;
        $this->blogCategoryService = $blogCategoryService;
    }

    public function index(Request $request)
    {
        $perPage = $request->input('length', config('UserManagement.user', 10));
        $serachTerm = $request->input('search');

        return $this->dataIndex($perPage, $serachTerm);
    }

    public function create()
    {
        $blogCategories =  $this->blogCategoryService->getSelectOptions(BlogCategoryDto::class);
        return $this->dataCreate(['blogCategories' => $blogCategories]);
    }

    public function store(BlogCreateUpdate $request)
    {
        return $this->dataStore($request);
    }

    public function edit($id)
    {
        $blogCategories =  $this->blogCategoryService->getSelectOptions(BlogCategoryDto::class);
        return $this->dataEdit($id, ['blogCategories' => $blogCategories]);
    }

    public function update(BlogCreateUpdate $request, $id)
    {
        return $this->dataUpdate($request, $id);
    }

    public function delete($id)
    {
        return $this->dataDelete($id);
    }

    public function updateOrder(Request $request)
    {
        return $this->updateOrderInternal($request, 'blogs', 'id', 'display_order');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        return $this->dataDelete($ids);
    }
}
