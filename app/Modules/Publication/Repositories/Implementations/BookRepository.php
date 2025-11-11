<?php

namespace App\Modules\Publication\Repositories\Implementations;

use App\Core\Repositories\Implementation\BaseRepository;
use App\Modules\Publication\Models\Book;
use App\Modules\Publication\Repositories\Interfaces\BookRepositoryInterface;

class BookRepository extends BaseRepository implements BookRepositoryInterface
{
    public function __construct(Book $model)
    {
        parent::__construct($model);
    }

    public function getRecordById($id)
    {
        return $this->model->findOrFail($id);
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
        ->select('id', 'title', 'slug', 'thumbnail_image','language', 'highlights', 'status','content')
        ->where('language', session('language', 'en'))
        ->where('status', 'active')
        ->where('highlights', $highlightType)
        ->get();
    }

    public function getSingleBookBySlug($slug)
    {
        $record  = $this->model->where('slug', $slug)->first();
        $bookId = $record->id;
        // dd($bookId);
        return $this->model
        ->select('id', 'title', 'slug', 'thumbnail_image', 'language', 'highlights', 'status', 'content')
        ->where('language', session('language', 'en'))
        ->where('status', 'active')
        ->where('slug', $slug)
        ->first();
    }

}
