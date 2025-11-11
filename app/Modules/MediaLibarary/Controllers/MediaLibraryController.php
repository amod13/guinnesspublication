<?php

namespace App\Modules\MediaLibarary\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\MediaLibarary\Services\Interfaces\MediaLibraryServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MediaLibraryController extends Controller
{
    protected $mediaService;

    public function __construct(MediaLibraryServiceInterface $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    public function index(Request $request)
    {
        $mediaItems = $this->mediaService->getAllMedia(
            20,
            $request->get('search'),
            $request->get('type')
        );

        if ($request->ajax()) {
            if ($request->has('selector')) {
                return response()->json([
                    'success' => true,
                    'media' => $mediaItems
                ]);
            }

            $view = $request->get('view', 'grid');
            $partial = $view === 'list' ? 'medialibarary::media-library.partials.list' : 'medialibarary::media-library.partials.grid';

            return response()->json([
                'success' => true,
                'media' => $mediaItems,
                'html' => view($partial, compact('mediaItems'))->render()
            ]);
        }

        return view('medialibarary::media-library.index', compact('mediaItems'));
    }

    public function upload(Request $request)
    {
        try {
            $request->validate([
                'files' => 'required|array',
                'files.*' => 'required|file|max:51200|mimes:jpeg,jpg,png,gif,webp,pdf,doc,docx,mp4,avi,mov,wmv,mp3,wav',
            ]);
            $uploadedFiles = [];
            foreach ($request->file('files') as $file) {
                if ($file->isValid()) {
                    $media = $this->mediaService->uploadFile($file);
                    $uploadedFiles[] = $media;
                }
            }

            return response()->json([
                'success' => true,
                'files' => $uploadedFiles,
                'media' => $uploadedFiles,
                'message' => count($uploadedFiles) . ' file(s) uploaded successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Upload failed: ' . $e->getMessage()
            ], 422);
        }
    }

    public function show($id)
    {
        $mediaItem = $this->mediaService->getMediaById($id);
        $mediaItem->url;
        return response()->json($mediaItem);
    }

    public function details($id)
    {
        $media = $this->mediaService->getMediaById($id);
        return view('medialibarary::media-library.partials.details', compact('media'))->render();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'alt_text' => 'nullable|string|max:255',
            'caption' => 'nullable|string',
            'description' => 'nullable|string'
        ]);

        $mediaItem = $this->mediaService->updateMedia($id, $request->only(['title', 'alt_text', 'caption', 'description']));

        return response()->json([
            'success' => true,
            'message' => 'Media updated successfully',
            'media' => $mediaItem
        ]);
    }

    public function destroy($id)
    {
        $this->mediaService->deleteMedia($id);

        return response()->json([
            'success' => true,
            'message' => 'Media deleted successfully'
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        $this->mediaService->bulkDeleteMedia($ids);

        return response()->json([
            'success' => true,
            'message' => count($ids) . ' items deleted successfully'
        ]);
    }

    public function modal(Request $request)
    {
        $mediaItems = $this->mediaService->getMediaForModal(
            $request->get('type'),
            $request->get('search'),
            12
        );

        return view('medialibarary::media-library.modal', compact('mediaItems'));
    }

    public function editImage(Request $request, $id)
    {
        $media = $this->mediaService->getMediaById($id);

        if (!$media->isImage()) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Only images can be edited'], 400);
            }
            return redirect()->route('media-library.index')->with('error', 'Only images can be edited');
        }

        if ($request->ajax()) {
            return view('medialibarary::media-library.edit-image-modal', compact('media'))->render();
        }

        return view('medialibarary::media-library.edit-image', compact('media'));
    }

    public function saveImage(Request $request, $id)
    {
        try {
            if (!$request->hasFile('image')) {
                return response()->json(['success' => false, 'message' => 'No image file provided'], 400);
            }

            $newMedia = $this->mediaService->editImage($id, $request->file('image'));

            return response()->json([
                'success' => true,
                'message' => 'New edited image created successfully',
                'new_media_id' => $newMedia->id
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function uploadChunk(Request $request)
    {
        try {
            $chunkData = [
                'chunkIndex' => $request->input('chunkIndex'),
                'totalChunks' => $request->input('totalChunks'),
                'fileId' => $request->input('fileId'),
                'fileName' => $request->input('fileName'),
                'fileSize' => $request->input('fileSize'),
                'chunk' => $request->file('chunk')
            ];

            $result = $this->mediaService->uploadChunk($chunkData);

            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }
}
