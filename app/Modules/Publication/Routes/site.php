<?php

use App\Modules\Publication\Controllers\Site\HomeController;
use Illuminate\Support\Facades\Route;


Route::middleware(['web'])->controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home.index');
    Route::get('/book/{slug}', 'getBookDetailBySlug')->name('single.book.detail');
    Route::get('/book/category/{slug}', 'giveMeBookByCategory')->name('book.list.by.category');
    Route::get('/page/{slug}', 'singlePage')->name('get.single.page');

    Route::get('/category-list', 'giveMeAllBookCategory')->name('book.category.list');
    Route::get('/author-list', 'giveMeAllAuthors')->name('site.author.list');

    // Search Route List
        Route::get('/s', 'globalSearch')->name('global.search'); //search books
        Route::get('/search-category', 'searchCategories')->name('site.category.search'); //search categories
});

Route::fallback(function () {
    return response()->view('publication::site.page.404.error', [], 404);
});

