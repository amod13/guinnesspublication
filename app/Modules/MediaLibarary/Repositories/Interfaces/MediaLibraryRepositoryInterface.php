<?php

namespace App\Modules\MediaLibarary\Repositories\Interfaces;

interface MediaLibraryRepositoryInterface
{
    public function getAll($perPage = 20, $searchTerm = null, $type = null);
    public function findById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function bulkDelete(array $ids);
    public function getByType($type, $perPage = 12);
    public function search($searchTerm, $type = null, $perPage = 20);
}