<?php

namespace App\Modules\EmployeeManagement\Services\Implementations;

use App\Modules\EmployeeManagement\Services\Interfaces\FileUploadServiceInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUploadService implements FileUploadServiceInterface
{
    public function uploadFile(
        UploadedFile $file,
        string $path,
        string $disk,
    ): string {
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $filename = $originalName . '_' . now()->timestamp . '.' . $extension;

        $file->storeAs($path, $filename, $disk);

        return $filename;
    }

    public function deleteFile(string $path, string $filename, $disk)
    {
        $fullPath = $path . '/' . $filename;
        if (Storage::disk($disk)->exists($fullPath)) {

            return Storage::disk($disk)->delete($fullPath);
        }
        return false;
    }

    // public function downloadFile(
    //     string $filename,
    //     string $path,
    //     string $disk = 'public'
    // ) {
    //     $filePath = $path . '/' . $filename;

    //     if (!Storage::disk($disk)->exists($filePath)) {
    //         abort(404, 'File not found');
    //     }

    //     $absolutePath = Storage::disk($disk)->path($filePath);

    //     return response()->download($absolutePath, $filename);
    // }
}
