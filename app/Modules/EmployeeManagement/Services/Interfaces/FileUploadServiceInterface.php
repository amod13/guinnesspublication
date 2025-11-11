<?php

namespace App\Modules\EmployeeManagement\Services\Interfaces;

use Illuminate\Http\UploadedFile;

interface FileUploadServiceInterface
{
    public function uploadFile(
        UploadedFile $file,
        string $path,
        string $disk,
    ): string;

    public function deleteFile(
        string $path,
        string $filename,
        string $disk,
    );

    // public function downloadFile(
    //     string $filename,
    //     string $path,
    //     string $disk = 'public'
    // );
}
