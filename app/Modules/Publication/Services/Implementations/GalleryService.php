<?php

namespace App\Modules\Publication\Services\Implementations;

use App\Core\Services\Implementation\BaseService;
use App\Core\Traits\HasPaginatedSearch;
use App\Modules\Publication\Repositories\Interfaces\GalleryRepositoryInterface;
use App\Modules\Publication\Services\Interfaces\GalleryServiceInterface;

class GalleryService extends BaseService implements GalleryServiceInterface
{
    use HasPaginatedSearch;

    public function __construct(GalleryRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function getPaginatedSearchResults(int $perPage, ?string $search = null, array $filters = [])
    {
        if (isset($filters['category_id'])) {
            // Return individual items for specific category
            $query = $this->repository->getModel()->where('category_id', $filters['category_id']);

            if ($search) {
                $query->where('caption', 'like', '%' . $search . '%');
            }

            $records = $query->orderBy('created_at', 'desc')->paginate($perPage);

            return ['records' => $records];
        }

        return $this->repository->getGroupedByCategory($perPage, $search);
    }

    public function createRecord($data)
    {
        if ($data['file_type'] === 'image' && isset($data['images'])) {
            return $this->createMultipleImages($data);
        }

        if ($data['file_type'] === 'video' && isset($data['video_urls'])) {
            return $this->createMultipleVideos($data);
        }

        return null;
    }

    private function createMultipleImages($data)
    {
        $galleries = [];
        $images = $data['images'];
        $captions = $data['captions'] ?? [];

        foreach ($images as $index => $image) {
            $imagePath = null;

            if ($image && $image->isValid()) {
                // Get real extension (jpg, png, etc.)
                $extension = $image->getClientOriginalExtension();

                // Generate unique name like 14245265.jpg
                $fileName = time() . rand(1000, 9999) . '.' . $extension;

                // Save image with this filename
                $imagePath = $image->storeAs('gallery', $fileName, 'public');
            }

            $galleries[] = $this->repository->createRecord([
                'category_id' => $data['category_id'],
                'file_type' => 'image',
                'image' => $fileName,
                'caption' => $captions[$index] ?? null,
            ]);
        }

        return $galleries;
    }

    private function createMultipleVideos($data)
    {
        $galleries = [];
        $videoUrls = $data['video_urls'] ?? [];
        $videoCaptions = $data['video_captions'] ?? [];

        foreach ($videoUrls as $index => $videoUrl) {
            if (!empty($videoUrl)) {
                $galleries[] = $this->repository->createRecord([
                    'category_id' => $data['category_id'],
                    'file_type' => 'video',
                    'video_url' => $videoUrl,
                    'caption' => $videoCaptions[$index] ?? null,
                ]);
            }
        }

        return $galleries;
    }


    public function updateRecord($data, $id)
    {
        $record = $this->repository->findById($id);

        if ($data['file_type'] === 'image' && isset($data['images']) && !empty($data['images'])) {
            // Handle new image upload
            $image = $data['images'][0]; // Take first image for single update
            if ($image && $image->isValid()) {
                // Delete old image if exists
                if ($record->image && file_exists(storage_path('app/public/gallery/' . $record->image))) {
                    unlink(storage_path('app/public/gallery/' . $record->image));
                }

                $extension = $image->getClientOriginalExtension();
                $fileName = time() . rand(1000, 9999) . '.' . $extension;
                $image->storeAs('gallery', $fileName, 'public');
                $data['image'] = $fileName;
            }
        }

        // Handle video caption
        if ($data['file_type'] === 'video' && isset($data['video_captions'][0])) {
            $data['caption'] = $data['video_captions'][0];
        }

        // Handle video URL
        if ($data['file_type'] === 'video' && isset($data['video_urls'][0])) {
            $data['video_url'] = $data['video_urls'][0];
        }

        // Handle image caption
        if ($data['file_type'] === 'image' && isset($data['captions'][0])) {
            $data['caption'] = $data['captions'][0];
        }

        return $this->repository->updateRecord($id, $data);
    }

    public function getGalleriesByCategory($categoryId)
    {
        return $this->repository->getGalleriesByCategory($categoryId);
    }

    public function getGalleryData()
    {
        return $this->repository->getGalleryData();
    }
}
