<?php
use App\Core\Helpers\ModuleMigrateHelper;
use App\Core\Http\ControllerInspectorController;
use App\Core\Http\LanguageController;
use App\Modules\Publication\Controllers\Site\HomeController;
use Illuminate\Support\Facades\Route;

// Default redirect to English
Route::get('/', function() {
    return redirect('/en');
});

// Site language routes
Route::group(['prefix' => '{locale}', 'middleware' => 'locale'], function() {
    // Include site routes
    require app_path('Modules/Publication/Routes/site.php');
    
    // 404 fallback for language routes
    Route::fallback(function () {
        return response()->view('publication::site.page.404.error', [], 404);
    });
});


// Controller bata function liyara permsiion table ma insert garne route
Route::get('/{controller}/get', [ControllerInspectorController::class, 'getControllerMethods']);


Route::get('/{module}/migrate', function ($module) {
    return ModuleMigrateHelper::migrate($module);
});

// Language switching routes
Route::get('/switch-language/{lang}', [LanguageController::class, 'switchLanguageForSite'])
    ->name('switch.language');

Route::post('/set-language', [LanguageController::class, 'setLanguage'])
    ->name('set.language');
