<?php

namespace App\Modules\Publication\Services\Implementations;

use App\Core\Helpers\ContentFormatter;
use App\Core\Services\Implementation\BaseService;
use App\Core\Utils\SlugGeneratorService;
use App\Modules\Publication\DTOs\Book\BookDto;
use App\Modules\Publication\Helpers\GeneratePdf;
use App\Modules\Publication\Repositories\Interfaces\BookRepositoryInterface;
use App\Modules\Publication\Services\Interfaces\BookCategoriesServiceInterface;
use App\Modules\Publication\Services\Interfaces\BookServiceInterface;

class BookService extends BaseService implements BookServiceInterface
{
    protected $bookCategoryService;
    public function __construct(BookRepositoryInterface $repository, BookCategoriesServiceInterface $bookCategoryService)
    {
        parent::__construct($repository);
        $this->bookCategoryService = $bookCategoryService;
    }

    public function createRecord($data)
    {
        $data['slug'] = SlugGeneratorService::generateSlug('books', $data['title']);
        // Handle media ID
        if (!empty($data['thumbnail_image_media_id'])) {
            $data['thumbnail_image'] = $data['thumbnail_image_media_id'];
        }
        if (!empty($data['pdf_file_media_id'])) {
            $data['pdf_file'] = $data['pdf_file_media_id'];
        }
        $data['language'] = session('language', 'en');

        return $this->repository->createRecord($data);
    }

    public function updateRecord($data, $id)
    {
        if (isset($data['name'])) {
            $data['slug'] = SlugGeneratorService::generateSlug('books', $data['title'], 'slug');
        }

        // Handle media ID
        if (!empty($data['thumbnail_image_media_id'])) {
            $data['thumbnail_image'] = $data['thumbnail_image_media_id'];
        }
        if (!empty($data['pdf_file_media_id'])) {
            $data['pdf_file'] = $data['pdf_file_media_id'];
        }
        $data['language'] = session('language', 'en');


        return $this->repository->updateRecord($id, $data);
    }

    public function getPaginatedSearchResults(int $perPage, ?string $search = null)
    {
        $filters = ['search' => $search];
        return $this->hasPaginatedWithSearch(
            perPage: $perPage,
            filters: $filters,
            searchableFields: ['title', 'category.name'],
            dtoClass: BookDto::class,
            useFromCollection: false,
            sortDir: 'asc',
            sortBy: 'display_order',
            baseQuery: null,
            filterField: 'language',
            filterId: session('language', 'en')
        );
    }

    public function getRecordById($id)
    {
        $record = $this->repository->getRecordById($id);

        if (auth()->check()) {
            $publicAllowedPdfPages = $this->repository->getPublicAllowedPages($id);
            $record->public_allowed_pdf_pages = $publicAllowedPdfPages;
            $record->generated_pdf = GeneratePdf::generateAllowedPagesPdf($id, $publicAllowedPdfPages);
        } else {
            $publicAllowedPdfPages = $this->repository->getPublicAllowedPages($id);
            $record->public_allowed_pdf_pages = $publicAllowedPdfPages;
            $record->generated_pdf = GeneratePdf::generateAllowedPagesPdf($id, $publicAllowedPdfPages);
        }

        return $record;
    }

    public function getPublishBooksByHighLightType($highlightType)
    {
        return $this->repository->getPublishBooksByHighLightType($highlightType);
    }


    public function getSingleBookBySlug($slug)
    {
        $bookDate = $this->repository->getBookIdBySlug($slug);
        $isLoginUser = auth()->check();

        // yo book sanga related book nikaleko catgory id bata
        $relatedBook = $this->repository->getRelatedBookByCategoryId($bookDate->category_id, $bookDate->id);

        // Fetch author details and limit content
        $bookAuthorDetails = $this->repository->getAuthorsByBookId($bookDate->id, session('language', 'en'));
        if ($bookAuthorDetails) {
            $bookAuthorDetails->content = ContentFormatter::limitWords($bookAuthorDetails->content, 20);
        }

        if ($isLoginUser) {
            $record = $this->repository->getRecordById($bookDate->id);
        } else {
            // Guest User
            $record = $this->repository->getRecordById($bookDate->id);
            $publicAllowedPdfPages = $this->repository->getPublicAllowedPages($bookDate->id);
            $record->public_allowed_pdf_pages = $publicAllowedPdfPages;
            $record->generated_pdf = GeneratePdf::generateAllowedPagesPdf($bookDate->id, $publicAllowedPdfPages);
        }

        return [
            'record' => $record,
            'isLoginUser' => $isLoginUser,
            'bookAuthorDetails' => $bookAuthorDetails,
            'relatedBook' => $relatedBook
        ];
    }

    public function giveMeBookByCategorySlug($slug)
    {
        // get gareko category id slug bata
        $bookDate = $this->bookCategoryService->getCategoryIdBySlug($slug);

        // tyo catgeory ko sanga related books taneko
        $data['booksByCategories'] = $this->repository->getBooksByCategoryId($bookDate->id);

        // active categories taneko
        $data['activeCategories'] = $this->bookCategoryService->getActiveBookCategories();

        return [
            'data' => $data
        ];
    }

    public function searchBookByKeyword($keyword)
    {
        // tyo catgeory ko sanga related books taneko
        $data['booksByCategories'] = $this->repository->searchBooksByKeyWord($keyword);

        // active categories taneko
        $data['activeCategories'] = $this->bookCategoryService->getActiveBookCategories();

        return [
            'data' => $data
        ];
    }

    public function getActiveBooks()
    {
        return $this->repository->getActiveBooks();
    }
}
