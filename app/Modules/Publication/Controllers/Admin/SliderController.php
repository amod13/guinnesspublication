<?php

namespace App\Modules\Publication\Controllers\Admin;

use App\Core\Http\BaseCrudController;
use App\Modules\Publication\DTOs\Slider\SliderDto;
use App\Modules\Publication\Requests\SliderCreateUpdate;
use App\Modules\Publication\Services\Interfaces\SliderServiceInterface;
use Illuminate\Http\Request;

class SliderController extends BaseCrudController
{
    protected string $viewPrefix = "publication::admin.slider.";
    protected string $routePrefix = 'slider.';
    protected string $entityName = 'Slider';

    protected $service, $selectOptionMapper;
    protected string $dtoClass = SliderDto::class;
    public function __construct(SliderServiceInterface $service)
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

    public function store(SliderCreateUpdate $request)
    {
        return $this->dataStore($request);
    }

    public function edit($id)
    {
        return $this->dataEdit($id);
    }

    public function update(SliderCreateUpdate $request, $id)
    {
        return $this->dataUpdate($request, $id);
    }

    public function delete($id)
    {
        return $this->dataDelete($id);
    }
    public function updateOrder(Request $request)
    {
        return $this->updateOrderInternal($request, 'sliders', 'id', 'display_order');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        return $this->dataDelete($ids);
    }

}
