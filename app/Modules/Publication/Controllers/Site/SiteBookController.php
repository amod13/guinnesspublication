<?php

namespace App\Modules\Publication\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Modules\Publication\Services\Interfaces\BookCategoriesServiceInterface;
use App\Modules\Publication\Services\Interfaces\BookServiceInterface;
use Illuminate\Http\Request;

class SiteBookController extends Controller
{
    protected string $viewPrefix = 'publication::site.';
    protected $BookService, $bookCategoryService;
    public function __construct(
        BookServiceInterface $BookService,
        BookCategoriesServiceInterface $bookCategoryService,
    ) {
        $this->BookService = $BookService;
        $this->bookCategoryService = $bookCategoryService;
    }


    public function giveMeAllBooks()
    {
        $data['activeCategories'] = $this->bookCategoryService->getBookCategories();
        $data['booksByCategories'] = $this->BookService->getActiveBooks();

        return view($this->viewPrefix . 'page.book.bookListByCategory', ['data' => $data]);
    }

    public function giveMeBookByCategory($language, $slug)
    {
        $response = $this->BookService->giveMeBookByCategorySlug($slug);

        return view($this->viewPrefix . 'page.book.bookListByCategory', [
            'data' => $response['data']
        ]);
    }

    public function getBookDetailBySlug($language, $slug)
    {
        $data['header_title'] = $slug;
        $data['book'] = $this->BookService->getSingleBookBySlug($slug);

        return view($this->viewPrefix . 'page.book.detail', ['data' => $data]);
    }

    public function globalSearch($language, Request $request)
    {
        $response = $this->BookService->searchBookByKeyword($request->all());
        $searchCriteria = $request->all();

        return view($this->viewPrefix . 'page.book.bookListByCategory', [
            'data' => $response['data']
        ])->with([
            'searchCriteria' => $searchCriteria,
        ]);
    }

        public function giveMeAllBookCategory()
    {
        $data['activeBookCategories'] = $this->bookCategoryService->getBookCategories();

        return view($this->viewPrefix . 'page.category.list', ['data' => $data]);
    }

    public function favouriteBooks(Request $request)
    {
        $request->validate([
            'book_id' => 'required',
        ]);

        // Check if user logged in
        if (!auth()->check()) {
            // If AJAX request, return JSON error
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Please login to add favourite books.',
                    'redirect' => route('site.login.form', ['lang' => app()->getLocale()])
                ], 401);
            }

            // Normal request
            return redirect()->route('site.login.form', ['lang' => app()->getLocale()])
                ->with('error', 'Please login to add favourite books.');
        }

        // Toggle favourite
        $user = auth()->user();
        $bookId = $request->book_id;

        $exists = $user->favouriteBooks()->where('book_id', $bookId)->exists();

        if ($exists) {
            $user->favouriteBooks()->detach($bookId);
            $status = 'removed';
        } else {
            $user->favouriteBooks()->attach($bookId);
            $status = 'added';
        }

        return response()->json([
            'status' => $status,
            'message' => $status === 'added' ? 'Book added to favourites!' : 'Book removed from favourites!',
        ]);
    }
}
