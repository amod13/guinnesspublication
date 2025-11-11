<?php

namespace App\Modules\MediaLibarary\Services\Interfaces;

interface MediaLibraryServiceInterface
{
    public function getAllMedia($perPage = 20, $searchTerm = null, $type = null);
    public function getMediaById($id);
    public function uploadFile($file);
    public function uploadChunk($chunkData);
    public function updateMedia($id, array $data);
    public function deleteMedia($id);
    public function bulkDeleteMedia(array $ids);
    public function editImage($id, $imageFile);
    public function getMediaForModal($type = null, $searchTerm = null, $perPage = 12);
}