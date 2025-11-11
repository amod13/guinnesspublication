<?php

namespace App\Modules\MediaLibarary\Repositories\Implementations;

use App\Modules\MediaLibarary\Models\MediaLibrary;
use App\Modules\MediaLibarary\Repositories\Interfaces\MediaLibraryRepositoryInterface;

class MediaLibraryRepository implements MediaLibraryRepositoryInterface
{
    protected $model;

    public function __construct(MediaLibrary $model)
    {
        $this->model = $model;
    }

    public function getAll($perPage = 20, $searchTerm = null, $type = null)
    {
        $query = $this->model->with('uploader')->latest();

        if ($type && $type !== 'all') {
            $query->where('file_type', $type);
        }

        if ($searchTerm) {
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('original_filename', 'like', '%' . $searchTerm . '%');
            });
        }

        return $query->paginate($perPage);
    }

    public function findById($id)
    {
        return $this->model->with('uploader')->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $media = $this->findById($id);
        $media->update($data);
        return $media;
    }

    public function delete($id)
    {
        $media = $this->findById($id);
        return $media->delete();
    }

    public function bulkDelete(array $ids)
    {
        return $this->model->whereIn('id', $ids)->get();
    }

    public function getByType($type, $perPage = 12)
    {
        return $this->model->where('file_type', $type)->latest()->paginate($perPage);
    }

    public function search($searchTerm, $type = null, $perPage = 20)
    {
        return $this->getAll($perPage, $searchTerm, $type);
    }
}