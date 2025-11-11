<?php

namespace App\Modules\Publication\Controllers\Admin;

use App\Core\Http\BaseCrudController;
use App\Modules\Publication\DTOs\AboutUs\AboutUsDto;
use App\Modules\Publication\Requests\AboutUsCreateUpdate;
use App\Modules\Publication\Services\Interfaces\AboutUsServiceInterface;
use Illuminate\Http\Request;

class AboutUsController extends BaseCrudController
{
    protected string $viewPrefix = "publication::admin.aboutUs.";
    protected string $routePrefix = 'about-us.';
    protected string $entityName = 'About Us';

    protected $service;
    protected string $dtoClass = AboutUsDto::class;

    public function __construct(AboutUsServiceInterface $service)
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

    public function store(AboutUsCreateUpdate $request)
    {
        $language = session('language', 'en');
        $result = $this->service->hasBaseDataForLanguage($language);

        if ($result === true) {
            return redirect()->back()
                ->with('error', 'About Us content for this language already exists.')
                ->withInput();
        }
        return $this->dataStore($request);
    }

    public function edit($id)
    {
        return $this->dataEdit($id);
    }

    public function update(AboutUsCreateUpdate $request, $id)
    {
        $language = session('language', 'en');
        $result = $this->service->hasBaseDataForLanguage($language, $id);

        if ($result === true) {
            return redirect()->back()
                ->with('error', 'About Us content for this language already exists.')
                ->withInput();
        }
        return $this->dataUpdate($request, $id);
    }

    public function delete($id)
    {
        return $this->dataDelete($id);
    }

    public function updateOrder(Request $request)
    {
        return $this->updateOrderInternal($request, 'about_us', 'id', 'display_order');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        return $this->dataDelete($ids);
    }
}
