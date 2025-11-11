<?php

namespace App\Modules\Publication\Controllers\Admin;

use App\Core\Http\BaseCrudController;
use App\Modules\Publication\DTOs\GalleryCategory\GalleryCategoryDto;
use App\Modules\Publication\Requests\GalleryCategoryCreateUpdate;
use App\Modules\Publication\Services\Interfaces\GalleryCategoryServiceInterface;
use Illuminate\Http\Request;

class GalleryCategoryController extends BaseCrudController
{
    protected string $viewPrefix = "publication::admin.gallery-category.";
    protected string $routePrefix = 'gallery-category.';
    protected string $entityName = 'Gallery Category';

    protected $service, $selectOptionMapper;
    protected string $dtoClass = GalleryCategoryDto::class;
    
    public function __construct(GalleryCategoryServiceInterface $service)
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

    public function store(GalleryCategoryCreateUpdate $request)
    {
        return $this->dataStore($request);
    }

    public function edit($id)
    {
        return $this->dataEdit($id);
    }

    public function update(GalleryCategoryCreateUpdate $request, $id)
    {
        return $this->dataUpdate($request, $id);
    }

    public function delete($id)
    {
        return $this->dataDelete($id);
    }
    
    public function updateOrder(Request $request)
    {
        return $this->updateOrderInternal($request, 'gallery_categories', 'id', 'display_order');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        return $this->dataDelete($ids);
    }
}