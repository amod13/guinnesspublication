<?php

use App\Modules\Publication\Controllers\Admin\AboutUsController;
use App\Modules\Publication\Controllers\Admin\BookCategoriesController;
use App\Modules\Publication\Controllers\Admin\BookController;
use App\Modules\Publication\Controllers\Admin\DealersController;
use App\Modules\Publication\Controllers\Admin\GalleryCategoryController;
use App\Modules\Publication\Controllers\Admin\GalleryController;
use App\Modules\Publication\Controllers\Admin\MarketingsController;
use App\Modules\Publication\Controllers\Admin\MenuController;
use App\Modules\Publication\Controllers\Admin\PageController;
use App\Modules\Publication\Controllers\Admin\SettingController;
use App\Modules\Publication\Controllers\Admin\SliderController;
use App\Modules\Publication\Controllers\Admin\ThemeSettingController;
use Illuminate\Support\Facades\Route;





Route::middleware(['web', 'auth'])->prefix('admin')->group(function () {
    //---------------------------MENU----------------------------
    Route::prefix('menu')->as('menu.')->controller(MenuController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::get('show/{id}', 'show')->name('show');
        Route::put('update/{id}', 'update')->name('update');
        Route::delete('destroy/{id}', 'delete')->name('destroy');
        Route::post('menus/update-position', 'updatePosition')->name('menus.updatePosition');
        Route::post('search/menu', 'getMenuSearchByMenuTypeIdAndCompanyIdBase')->name('search');
        Route::get('search/menu', 'getMenuSearchByMenuTypeIdAndCompanyIdBase');
        Route::post('update-order', 'updateOrder')->name('updateOrder');
    });

    //---------------------------Page-----------------------------
    Route::prefix('page')->as('page.')->controller(PageController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::get('show/{id}', 'show')->name('show');
        Route::put('update/{id}', 'update')->name('update');
        Route::delete('destroy/{id}', 'delete')->name('destroy');
        Route::delete('bulk-delete', 'bulkDelete')->name('bulk.delete');
        Route::get('/update-order', 'updateOrder')->name('order');
    });

    //---------------------------Setting-----------------------------
    Route::prefix('setting')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('setting.index');
        Route::put('update/{id}', [SettingController::class, 'update'])->name('setting.update');
    });

    Route::get('/theme-settings', [ThemeSettingController::class, 'index'])->name('theme-settings.index');
    Route::post('/theme-settings', [ThemeSettingController::class, 'store'])->name('theme-settings.store');

    //---------------------------BookCategories SECTION ROUTE-----------------------------
    Route::prefix('book-category')->as('bookcategories.')->controller(BookCategoriesController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::get('show/{id}', 'show')->name('show');
        Route::put('update/{id}', 'update')->name('update');
        Route::delete('destroy/{id}', 'destroy')->name('destroy');
        Route::delete('bulk-delete', 'bulkDelete')->name('bulk-delete');
        Route::get('update-order', 'updateOrder')->name('order');
    });

    //---------------------------BOOKS SECTION ROUTE-----------------------------
    Route::prefix('book')->as('books.')->controller(BookController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::get('show/{id}', 'show')->name('show');
        Route::put('update/{id}', 'update')->name('update');
        Route::delete('destroy/{id}', 'destroy')->name('destroy');
        Route::delete('bulk-delete', 'bulkDelete')->name('bulk-delete');
        Route::get('update-order', 'updateOrder')->name('order');
        Route::get('{id}/pdf', 'showPdf')->name('pdf');
        Route::get('list', 'getActiveBooksForDealer')->name('list');
        Route::get('detail/{id}', 'getBookDetails')->name('detail');
    });

    //---------------------------SLIDER SECTION ROUTE-----------------------------
    Route::prefix('slider')->as('slider.')->controller(SliderController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::get('show/{id}', 'show')->name('show');
        Route::put('update/{id}', 'update')->name('update');
        Route::delete('destroy/{id}', 'delete')->name('destroy');
        Route::delete('bulk-delete', 'bulkDelete')->name('bulk.delete');
        Route::get('/update-order', 'updateOrder')->name('order');
    });

    //---------------------------About Us-----------------------------
    Route::prefix('about-us')->as('about-us.')->controller(AboutUsController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::get('show/{id}', 'show')->name('show');
        Route::put('update/{id}', 'update')->name('update');
        Route::delete('destroy/{id}', 'delete')->name('destroy');
        Route::get('update-order', 'updateOrder')->name('updateOrder');
        Route::delete('bulk-delete', 'bulkDelete')->name('bulkDelete');
    });


    //---------------------------Marketings SECTION ROUTE-----------------------------
    Route::prefix('marketings')->as('marketings.')->controller(MarketingsController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::get('show/{id}', 'show')->name('show');
        Route::put('update/{id}', 'update')->name('update');
        Route::delete('destroy/{id}', 'destroy')->name('destroy');
        Route::delete('bulk-delete', 'bulkDelete')->name('bulk-delete');
        Route::get('update-order', 'updateOrder')->name('order');
    });



    //---------------------------Dealers SECTION ROUTE-----------------------------
    Route::prefix('dealers')->as('dealers.')->controller(DealersController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::get('show/{id}', 'show')->name('show');
        Route::put('update/{id}', 'update')->name('update');
        Route::delete('destroy/{id}', 'destroy')->name('destroy');
        Route::delete('bulk-delete', 'bulkDelete')->name('bulk-delete');
        Route::post('update-order', 'updateOrder')->name('order');
    });


    //---------------------------Gallery Category-----------------------------
    Route::prefix('gallery-category')->as('gallery-category.')->controller(GalleryCategoryController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::get('show/{id}', 'show')->name('show');
        Route::put('update/{id}', 'update')->name('update');
        Route::delete('destroy/{id}', 'delete')->name('destroy');
        Route::delete('bulk-delete', 'bulkDelete')->name('bulk.delete');
        Route::get('/update-order', 'updateOrder')->name('order');
    });

    //---------------------------Gallery-----------------------------
    Route::prefix('gallery')->as('gallery.')->controller(GalleryController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::get('show/{id}', 'show')->name('show');
        Route::put('update/{id}', 'update')->name('update');
        Route::delete('destroy/{id}', 'delete')->name('destroy');
        Route::delete('bulk-delete', 'bulkDelete')->name('bulk.delete');
    });

});
