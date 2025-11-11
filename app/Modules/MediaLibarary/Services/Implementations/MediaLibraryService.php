<?php

namespace App\Modules\MediaLibarary\Services\Implementations;

use App\Modules\MediaLibarary\Repositories\Interfaces\MediaLibraryRepositoryInterface;
use App\Modules\MediaLibarary\Services\Interfaces\MediaLibraryServiceInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaLibraryService implements MediaLibraryServiceInterface
{
    protected $repository;

    public function __construct(MediaLibraryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAllMedia($perPage = 20, $searchTerm = null, $type = null)
    {
        return $this->repository->getAll($perPage, $searchTerm, $type);
    }

    public function getMediaById($id)
    {
        return $this->repository->findById($id);
    }

    public function uploadFile($file)
    {
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $mimeType = $file->getMimeType();
        $fileSize = $file->getSize();
        $fileType = $this->getFileType($mimeType);

        $filename = time() . '_' . Str::random(10) . '.' . $extension;
        
        $storedPath = $file->storeAs('public/media-library', $filename);
        if (!$storedPath) {
            throw new \Exception('Failed to store uploaded file');
        }

        $fullPath = storage_path('app/public/media-library/' . $filename);
        $metadata = $this->getFileMetadata($fullPath, $fileType);

        return $this->repository->create([
            'title' => pathinfo($originalName, PATHINFO_FILENAME),
            'filename' => $filename,
            'original_filename' => $originalName,
            'file_path' => 'storage/media-library/' . $filename,
            'mime_type' => $mimeType,
            'file_type' => $fileType,
            'file_size' => $fileSize,
            'metadata' => $metadata,
            'uploaded_by' => auth()->id()
        ]);
    }

    public function uploadChunk($chunkData)
    {
        $chunkIndex = $chunkData['chunkIndex'];
        $totalChunks = $chunkData['totalChunks'];
        $fileId = $chunkData['fileId'];
        $fileName = $chunkData['fileName'];
        $fileSize = $chunkData['fileSize'];
        $chunk = $chunkData['chunk'];

        $tempDir = storage_path('app/temp/chunks/' . $fileId);
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $chunkPath = $tempDir . '/chunk_' . $chunkIndex;
        $chunk->move($tempDir, 'chunk_' . $chunkIndex);

        if ($chunkIndex == $totalChunks - 1) {
            return $this->mergeChunks($fileId, $fileName, $fileSize, $totalChunks, $chunkData);
        }

        return ['success' => true, 'message' => 'Chunk uploaded'];
    }

    private function mergeChunks($fileId, $fileName, $fileSize, $totalChunks, $chunkData = null)
    {
        $tempDir = storage_path('app/temp/chunks/' . $fileId);
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        $finalFileName = time() . '_' . Str::random(10) . '.' . $extension;
        $finalPath = storage_path('app/public/media-library/' . $finalFileName);

        if (!file_exists(dirname($finalPath))) {
            mkdir(dirname($finalPath), 0755, true);
        }

        $finalFile = fopen($finalPath, 'wb');
        for ($i = 0; $i < $totalChunks; $i++) {
            $chunkPath = $tempDir . '/chunk_' . $i;
            $chunkFile = fopen($chunkPath, 'rb');
            stream_copy_to_stream($chunkFile, $finalFile);
            fclose($chunkFile);
            unlink($chunkPath);
        }
        fclose($finalFile);
        rmdir($tempDir);

        $mimeType = ($chunkData && isset($chunkData['mimeType'])) ? $chunkData['mimeType'] : mime_content_type($finalPath);
        $fileType = $this->getFileType($mimeType);
        $metadata = $this->getFileMetadata($finalPath, $fileType);

        return $this->repository->create([
            'title' => pathinfo($fileName, PATHINFO_FILENAME),
            'filename' => $finalFileName,
            'original_filename' => $fileName,
            'file_path' => 'storage/media-library/' . $finalFileName,
            'mime_type' => $mimeType,
            'file_type' => $fileType,
            'file_size' => $fileSize,
            'metadata' => $metadata,
            'uploaded_by' => auth()->id()
        ]);
    }

    public function updateMedia($id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function deleteMedia($id)
    {
        $media = $this->repository->findById($id);
        
        // Delete file
        $storagePath = str_replace('storage/', 'public/', $media->file_path);
        if (Storage::exists($storagePath)) {
            Storage::delete($storagePath);
        }

        return $this->repository->delete($id);
    }

    public function bulkDeleteMedia(array $ids)
    {
        $mediaItems = $this->repository->bulkDelete($ids);

        foreach ($mediaItems as $item) {
            $storagePath = str_replace('storage/', 'public/', $item->file_path);
            if (Storage::exists($storagePath)) {
                Storage::delete($storagePath);
            }
            $item->delete();
        }

        return true;
    }

    public function editImage($id, $imageFile)
    {
        $originalMedia = $this->repository->findById($id);

        if (!$originalMedia->isImage()) {
            throw new \Exception('Only images can be edited');
        }

        $filename = time() . '_edited_' . Str::random(10) . '.jpg';
        $relativePath = 'media-library/' . $filename;
        $storedPath = $imageFile->storeAs('public/' . $relativePath);

        if ($storedPath) {
            $fullPath = storage_path('app/public/' . $relativePath);
            $metadata = $this->getFileMetadata($fullPath, 'image');

            return $this->repository->create([
                'title' => $originalMedia->title . ' (Edited)',
                'filename' => $filename,
                'original_filename' => $originalMedia->original_filename,
                'file_path' => 'storage/' . $relativePath,
                'mime_type' => 'image/jpeg',
                'file_type' => 'image',
                'file_size' => $imageFile->getSize(),
                'metadata' => $metadata,
                'alt_text' => $originalMedia->alt_text,
                'caption' => $originalMedia->caption,
                'description' => $originalMedia->description,
                'uploaded_by' => auth()->id()
            ]);
        }

        throw new \Exception('Failed to save image');
    }

    public function getMediaForModal($type = null, $searchTerm = null, $perPage = 12)
    {
        return $this->repository->getAll($perPage, $searchTerm, $type);
    }

    private function getFileType($mimeType)
    {
        if (str_starts_with($mimeType, 'image/')) return 'image';
        if (str_starts_with($mimeType, 'video/')) return 'video';
        if (str_starts_with($mimeType, 'audio/')) return 'audio';
        return 'document';
    }

    private function getFileMetadata($filePath, $fileType)
    {
        $metadata = [];

        if ($fileType === 'image' && function_exists('getimagesize')) {
            $imageInfo = getimagesize($filePath);
            if ($imageInfo) {
                $metadata['width'] = $imageInfo[0];
                $metadata['height'] = $imageInfo[1];
            }
        }

        return $metadata;
    }
}