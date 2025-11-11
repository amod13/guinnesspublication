<?php

use App\Modules\Publication\Controllers\Site\HomeController;
use Illuminate\Support\Facades\Route;


Route::middleware(['web'])->controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home.index');
    Route::get('/book/{slug}', 'getBookDetailBySlug')->name('single.book.detail');
    Route::get('/page/{slug}', 'singlePage')->name('get.single.page');
});

Route::fallback(function () {
    return response()->view('publication::site.page.404.error', [], 404);
});

