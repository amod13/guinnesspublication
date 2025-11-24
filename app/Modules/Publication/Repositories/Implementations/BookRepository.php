<?php

namespace App\Modules\Publication\Repositories\Implementations;

use App\Core\Repositories\Implementation\BaseRepository;
use App\Modules\Publication\Models\Book;
use App\Modules\Publication\Repositories\Interfaces\BookRepositoryInterface;
use Illuminate\Support\Facades\DB;

class BookRepository extends BaseRepository implements BookRepositoryInterface
{
    public function __construct(Book $model)
    {
        parent::__construct($model);
    }

    public function getRecordById($id)
    {
        // 'category' relationship लाई Eager Load गर्ने
        return $this->model->with('category')->findOrFail($id);
    }

    public function getPublicAllowedPages($id)
    {
        $record = $this->model->where('id', $id)
            ->select('public_pdf_pages')
            ->first();

        if (!$record || empty($record->public_pdf_pages)) {
            return [];
        }

        // Split by comma and trim each value
        $pages = array_map('trim', explode(',', $record->public_pdf_pages));

        // Optionally convert to integer array
        $pages = array_map('intval', $pages);

        return $pages;
    }

    public function getPublishBooksByHighLightType($highlightType)
    {
        return $this->model
            ->select('id', 'title', 'slug', 'thumbnail_image', 'language', 'highlights', 'status', 'content')
            ->where('language', session('language', 'en'))
            ->where('status', 'active')
            ->where('highlights', $highlightType)
            ->get();
    }

    public function getAuthorsByBookId($bookId, $language)
    {
        return $this->model
            ->join('authors', 'authors.id', '=', $this->model->getTable() . '.author_id')
            ->select('authors.name', 'authors.id', 'authors.image', 'authors.slug', 'authors.content')
            ->where($this->model->getTable() . '.id', $bookId)
            ->where('authors.status', 'active')
            ->where('authors.language', $language)
            ->first();
    }

    public function getBookIdBySlug($slug)
    {
        $record  = $this->model->where('slug', $slug)->select('id', 'category_id')->first();
        return $record;
    }

    public function getRelatedBookByCategoryId($categoryId, $excludeBookId = null)
    {
        $query = $this->model
            ->with(['category:id,name,slug'])
            ->with(['author:id,name,slug'])
            ->select('id', 'title', 'slug', 'thumbnail_image', 'language', 'highlights', 'status', 'content', 'category_id', 'author_id')
            ->where('language', session('language', 'en'))
            ->where('status', 'active')
            ->where('category_id', $categoryId);

        if ($excludeBookId) {
            $query->where('id', '!=', $excludeBookId); // exclude current book
        }

        return $query->get();
    }

    public function getBooksByCategoryId($categoryId)
    {
        return $this->model
            ->with(['category:id,name,slug'])
            ->with(['author:id,name,slug'])
            ->select('id', 'title', 'slug', 'thumbnail_image', 'language', 'highlights', 'status', 'content', 'category_id', 'author_id')
            ->where('language', session('language', 'en'))
            ->where('status', 'active')
            ->where('category_id', $categoryId)
            ->paginate(12);
    }

    public function searchBookByKeyword($keyword)
    {
        return $this->model
            ->with('category:id,name,slug') // category load
            ->with('author:id,name,slug')
            ->select('id', 'title', 'slug', 'thumbnail_image', 'language', 'highlights', 'status', 'content', 'category_id', 'author_id')
            ->where('language', session('language', 'en'))
            ->where('status', 'active')
            ->where(function ($query) use ($keyword) {
                $query->where('title', 'LIKE', "%{$keyword}%")
                    ->orWhere('highlights', 'LIKE', "%{$keyword}%")
                    ->orWhere('content', 'LIKE', "%{$keyword}%")
                    ->orWhere('slug', 'LIKE', "%{$keyword}%");
            })
            ->paginate(12);
    }

    public function getActiveBooks()
    {
        return $this->model
            ->with('category:id,name,slug') // category load
            ->with('author:id,name,slug')
            ->select('id', 'title', 'slug', 'thumbnail_image', 'language', 'highlights', 'status', 'content', 'category_id', 'author_id')
            ->where('language', session('language', 'en'))
            ->where('status', 'active')
            ->paginate(12);
    }
}
