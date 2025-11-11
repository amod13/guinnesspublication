<?php

namespace App\Modules\Publication\Services\Implementations;

use App\Core\Services\Implementation\BaseService;
use App\Core\Traits\HasPaginatedSearch;
use App\Core\Utils\SlugGeneratorService;
use App\Modules\Publication\DTOs\Book\BookDto;
use App\Modules\Publication\Helpers\GeneratePdf;
use App\Modules\Publication\Repositories\Interfaces\BookRepositoryInterface;
use App\Modules\Publication\Services\Interfaces\BookServiceInterface;

class BookService extends BaseService implements BookServiceInterface
{
    use HasPaginatedSearch;

    public function __construct(BookRepositoryInterface $repository)
    {
        parent::__construct($repository);
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
            $record->public_allowed_pdf_pages = [];
            $record->generated_pdf = null;
        }

        return $record;
    }

    public function getPublishBooksByHighLightType($highlightType)
    {
        return $this->repository->getPublishBooksByHighLightType($highlightType);
    }

    public function getSingleBookBySlug($slug)
    {
        return $this->repository->getSingleBookBySlug($slug);
    }
}
