<?php

use App\Modules\Publication\Controllers\Site\HomeController;
use App\Modules\Publication\Controllers\Site\LoginController;
use Illuminate\Support\Facades\Route;



Route::middleware(['web'])->controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home.index');

    // Page Route
    Route::get('/page/{slug}', 'singlePage')->name('get.single.page');

    // Books Route
    Route::get('/book/{slug}', 'getBookDetailBySlug')->name('single.book.detail');
    Route::get('/book/category/{slug}', 'giveMeBookByCategory')->name('book.list.by.category');
    Route::get('/book-category-list', 'giveMeAllBookCategory')->name('book.category.list');
    Route::get('/book-list', 'giveMeAllBooks')->name('site.book.list');

    // Author Route
    Route::get('/author-list', 'giveMeAllAuthors')->name('site.author.list');

    // Search Route List
    Route::get('/s', 'globalSearch')->name('global.search'); //search books
    Route::get('/search-category', 'searchCategories')->name('site.category.search'); //search categories

    // Blog Page
      Route::get('/blogs', 'giveMeAllBlogs')->name('site.blog.list');
      Route::get('/blog/{slug}', 'singleBlog')->name('site.blog.detail');
      Route::post('/blog/search', 'searchBlogs')->name('site.blog.search');

    // about page
    Route::get('/about', 'aboutUs')->name('site.about.us');

    // Gallery Route
    Route::get('/galleries', 'giveMeGallery')->name('site.gallery');

    // Contact Us
    Route::get('/contact-us', 'contactUs')->name('site.contact.us');
    Route::post('/contact-us', 'storeContactMessages')->name('store.contact.us');
});


Route::middleware(['web'])->controller(LoginController::class)->group(function () {
    Route::get('/login', 'loginForm')->name('site.login.form');
    Route::post('/login/store', 'login')->name('site.login.store');
    Route::post('/logout', 'logout')->name('site.logout');
    Route::get('/resgiter', 'showRegisterForm')->name('site.register.form');
    Route::post('/resister', 'register')->name('site.register');

    // Google Login
   Route::get('site/auth/google', 'redirectToGoogle')->name('site.auth.google');
    Route::get('/auth/google/callback', 'handleGoogleCallback')->name('site.auth.google.callback');
});

Route::fallback(function () {
    return response()->view('publication::site.page.404.error', [], 404);
});
