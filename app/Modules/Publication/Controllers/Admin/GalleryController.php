<?php

namespace App\Modules\Publication\Controllers\Admin;

use App\Core\Http\BaseCrudController;
use App\Modules\Publication\DTOs\Gallery\GalleryDto;
use App\Modules\Publication\Requests\GalleryCreateUpdate;
use App\Modules\Publication\Services\Interfaces\GalleryCategoryServiceInterface;
use App\Modules\Publication\Services\Interfaces\GalleryServiceInterface;
use Illuminate\Http\Request;

class GalleryController extends BaseCrudController
{
    protected string $viewPrefix = "publication::admin.gallery.";
    protected string $routePrefix = 'gallery.';
    protected string $entityName = 'Gallery';

    protected $service, $selectOptionMapper;
    protected string $dtoClass = GalleryDto::class;

    protected $galleryCategoryService;

    public function __construct(
        GalleryServiceInterface $service,
        GalleryCategoryServiceInterface $galleryCategoryService
    ) {
        $this->service = $service;
        $this->galleryCategoryService = $galleryCategoryService;
    }

    public function index(Request $request)
    {
        $perPage = $request->input('length', config('UserManagement.user', 10));
        $searchTerm = $request->input('search');
        $categoryId = $request->input('category');

        if ($categoryId) {
            // Show individual items for specific category
            $data = $this->service->getPaginatedSearchResults(30, $searchTerm, ['category_id' => $categoryId]);
            $category = $this->galleryCategoryService->findById($categoryId);
            return view($this->viewPrefix . 'items', compact('data', 'category'));
        }

        // Show grouped by category
        $data['records'] = $this->service->getPaginatedSearchResults($perPage, $searchTerm);
        return view($this->viewPrefix . 'index', compact('data'));
    }

    public function create(Request $request)
    {
        $categories = $this->galleryCategoryService->getActiveGalleryCategories();
        $selectedCategory = $request->input('category');
        return $this->dataCreate(['categories' => $categories, 'selected_category' => $selectedCategory]);
    }

    public function store(Request $request)
    {
        
        try {
            $result = $this->service->createRecord($request->all());

            $categoryId = $request['category_id'];

            if (is_array($result)) {
                $count = count($result);
                return redirect()->route('gallery.index', ['category' => $categoryId])
                    ->with('success', "Successfully created {$count} gallery items.");
            }

            return redirect()->route('gallery.index', ['category' => $categoryId])
                ->with('success', 'Gallery created successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create gallery: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $categories = $this->galleryCategoryService->getActiveGalleryCategories();
        return $this->dataEdit($id, ['categories' => $categories]);
    }

    public function update(GalleryCreateUpdate $request, $id)
    {
        try {
            $record = $this->service->findById($id);
            $categoryId = $record->category_id;

            $this->service->updateRecord($request->validated(),$id);

            return redirect()->route('gallery.index', ['category' => $categoryId])
                ->with('success', 'Gallery item updated successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update gallery item: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $record = $this->service->findById($id);
            $categoryId = $record->category_id;

            $this->service->deleteRecord($id);

            return redirect()->route('gallery.index', ['category' => $categoryId])
                ->with('success', 'Gallery item deleted successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete gallery item: ' . $e->getMessage());
        }
    }

    public function bulkDelete(Request $request)
    {
        try {
            $ids = $request->input('ids', []);
            $categoryId = null;

            if (!empty($ids)) {
                $firstRecord = $this->service->findById($ids[0]);
                $categoryId = $firstRecord->category_id;

                foreach ($ids as $id) {
                    $this->service->deleteRecord($id);
                }
            }

            $redirectUrl = $categoryId ? route('gallery.index', ['category' => $categoryId]) : route('gallery.index');

            return redirect($redirectUrl)
                ->with('success', 'Selected gallery items deleted successfully.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete gallery items: ' . $e->getMessage());
        }
    }
}
