<?php

use App\Modules\MediaLibarary\Controllers\MediaLibraryController;
use Illuminate\Support\Facades\Route;


Route::middleware(['web', 'auth'])->prefix('admin')->group(function () {
    // Media Library Routes
    Route::prefix('media-library')->group(function () {
        Route::get('/', [MediaLibraryController::class, 'index'])->name('media-library.index');
        Route::post('/upload', [MediaLibraryController::class, 'upload'])->name('media-library.upload');
        Route::post('/upload-chunk', [MediaLibraryController::class, 'uploadChunk'])->name('media-library.upload-chunk');
        Route::get('/modal', [MediaLibraryController::class, 'modal'])->name('media-library.modal');
        Route::get('/{id}', [MediaLibraryController::class, 'show'])->name('media-library.show');
        Route::get('/{id}/details', [MediaLibraryController::class, 'details'])->name('media-library.details');
        Route::get('/{id}/edit-image', [MediaLibraryController::class, 'editImage'])->name('media-library.edit-image');
        Route::post('/{id}/save-image', [MediaLibraryController::class, 'saveImage'])->name('media-library.save-image');
        Route::put('/{id}', [MediaLibraryController::class, 'update'])->name('media-library.update');
        Route::delete('/{id}', [MediaLibraryController::class, 'destroy'])->name('media-library.destroy');
        Route::delete('/bulk/delete', [MediaLibraryController::class, 'bulkDelete'])->name('media-library.bulk-delete');
    });
});
