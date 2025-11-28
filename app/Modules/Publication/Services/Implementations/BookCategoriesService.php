<?php

namespace App\Modules\Publication\Services\Implementations;

use App\Core\Services\Implementation\BaseService;
use App\Modules\Publication\DTOs\BookCategories\BookCategoriesDto;
use App\Core\Utils\SlugGeneratorService;
use App\Core\Traits\HasPaginatedSearch;
use App\Modules\Publication\Services\Interfaces\BookCategoriesServiceInterface;
use App\Modules\Publication\Repositories\Interfaces\BookCategoriesRepositoryInterface;
use App\Modules\Publication\Repositories\Interfaces\BookRepositoryInterface;

class BookCategoriesService extends BaseService implements BookCategoriesServiceInterface
{
    use HasPaginatedSearch;
    protected $bookRepository;
    public function __construct(BookCategoriesRepositoryInterface $repository, BookRepositoryInterface $bookRepository)
    {
        parent::__construct($repository);
        $this->bookRepository = $bookRepository;
    }
    public function createRecord($data)
    {
        $data['slug'] = SlugGeneratorService::generateSlug('book_categories', $data['name']);

        $data['language'] = session('language', 'en');
        // Handle media ID
        if (!empty($data['thumbnail_image_media_id'])) {
            $data['thumbnail_image'] = $data['thumbnail_image_media_id'];
        }

        return $this->repository->createRecord($data);
    }

    public function updateRecord($data, $id)
    {
        if (isset($data['name'])) {
            $data['slug'] = SlugGeneratorService::generateSlug(
                'book_categories',
                $data['name'],
                'slug'
            );
        }

        if (!empty($data['thumbnail_image_media_id'])) {
            $data['thumbnail_image'] = $data['thumbnail_image_media_id'];
        }

        $data['language'] = session('language', 'en');

        $parentId = $data['parent_id'] ?? null;

        // FIRST: Always update the record
        $updated = $this->repository->updateRecord($id, $data);

        // IF parent exists → redirect to parent page
        if ($parentId) {
            return [
                'redirect' => true,
                'success' => (bool) $updated,
                'message' => "Parent Category updated successfully (ID: $parentId)",
                'parent_id' => $parentId,
            ];
        }

        // ELSE → normal redirect
        return [
            'redirect' => false,
            'success' => (bool) $updated,
            'message' => $updated
                ? 'Data Updated successfully'
                : 'Unable to Update the data',
            'parent_id' => null,
        ];
    }


    public function deleteRecord($id)
    {
        //check garna paryo yasko parent xa kin nai
        $hasParent = $this->repository->hasParent($id);

        //yadi parent xa vani
        if ($hasParent) {
            //delete parent category and its children
            return $this->repository->deleteCategoryWithChildren($id);
        }
    }

    public function getPaginatedSearchResults(int $perPage, ?string $search = null)
    {
        $filters = ['search' => $search];
        $baseQuery = $this->repository->getDataForTable();
        return $this->hasPaginatedWithSearch(
            perPage: $perPage,
            filters: $filters,
            searchableFields: ['name'],
            dtoClass: BookCategoriesDto::class,
            useFromCollection: false,
            sortDir: 'asc',
            sortBy: 'display_order',
            baseQuery: $baseQuery,
            filterField: 'language',
            filterId: session('language', 'en')
        );
    }

    public function getActiveBookCategories()
    {
        return $this->repository->getActiveBookCategories();
    }
    public function getCategoryIdBySlug($slug)
    {
        return $this->repository->getCategoryIdBySlug($slug);
    }

    public function getBookCategories()
    {
        return $this->repository->getBookCategories();
    }

    public function searchCategories($data)
    {
        $data['activeBookCategories'] = $this->repository->searchCategories($data);
        return [
            'data' => $data
        ];
    }

    public function getBookCategoryWithChildren()
    {
        return $this->repository->getBookCategoryWithChildren();
    }

    public function parentCategory($id)
    {
        return $this->repository->parentCategory($id);
    }
    public function getActiverCategoryNotInParent()
    {
        return $this->repository->getActiverCategoryNotInParent();
    }

    public function getAllCategoryWithSubCategory($slug)
    {
        $data['categoryDetail'] = $this->repository->getAllCategoryWithSubCategory($slug);
        $bookDate = $this->repository->getCategoryIdBySlug($slug);
        $data['activeCategories'] = $this->getCategoriesWithParentAndChild();
        // tyo catgeory ko sanga related books taneko
        $data['booksByCategories'] = $this->bookRepository->getBooksByCategoryId($bookDate->id);
        return [
            'data' => $data
        ];
    }

    public function getCategoriesWithParentAndChild()
    {
        return $this->repository->getCategoriesWithParentAndChild();
    }
}
