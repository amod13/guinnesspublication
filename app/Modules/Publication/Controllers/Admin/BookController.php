<?php

namespace App\Modules\Publication\Controllers\Admin;

use App\Core\Http\BaseCrudController;
use App\Modules\Publication\DTOs\Book\BookDto;
use App\Modules\Publication\Enums\HighlightTypeEnum;
use App\Modules\Publication\Requests\BookCreateUpdateRequest;
use App\Modules\Publication\Services\Interfaces\BookCategoriesServiceInterface;
use App\Modules\Publication\Services\Interfaces\BookServiceInterface;
use Illuminate\Http\Request;

class BookController extends BaseCrudController
{
    protected string $viewPrefix = "publication::admin.books.";
    protected string $routePrefix = 'books.';
    protected string $entityName = 'Book';
    protected string $dtoClass = BookDto::class;
    protected $categoryService;

    public function __construct(BookServiceInterface $service, BookCategoriesServiceInterface $categoryService)
    {
        $this->service = $service;
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        $perPage = $request->input('length', 10);
        $searchTerm = $request->input('search');

        return $this->dataIndex($perPage, $searchTerm);
    }

    public function create()
    {
        $highlights = HighlightTypeEnum::list();
        $bookCategories = $this->categoryService->getActiveBookCategories();

        return $this->dataCreate(['highlights' => $highlights, 'bookCategories' => $bookCategories]);
    }

    public function store(BookCreateUpdateRequest $request)
    {
        return $this->dataStore($request);
    }

    public function show($id)
    {
        $data['header_title'] = 'View Book';
        $data['record'] = $this->service->getRecordById($id);
        return view($this->viewPrefix . 'show', ['data' => $data]);
    }

    public function edit($id)
    {
        $highlights = HighlightTypeEnum::list();
        $bookCategories = $this->categoryService->getActiveBookCategories();
        return $this->dataEdit($id, ['highlights' => $highlights, 'bookCategories' => $bookCategories]);
    }

    public function update(BookCreateUpdateRequest $request, $id)
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
        return $this->updateOrderInternal($request, 'books', 'id', 'display_order');
    }

    public function showPdf($id)
    {
        $book = $this->service->getRecordById($id);

        if (!isset($book->generated_pdf)) {
            abort(404, 'PDF not available');
        }

        return response($book->generated_pdf)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="book-' . $id . '.pdf"');
    }

    public function getActiveBooksForDealer()
    {
        $data['books'] = $this->service->getActiveRecords();

        return view($this->viewPrefix . 'list', ['data' => $data]);
    }

    public function getBookDetails($id)
    {
        $data['book'] = $this->service->findByid($id);

        return view($this->viewPrefix . 'detail', ['data' => $data]);
    }

}
