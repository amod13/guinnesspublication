<?php

namespace App\Modules\MediaLibarary\Providers;

use App\Modules\MediaLibarary\Repositories\Implementations\MediaLibraryRepository;
use App\Modules\MediaLibarary\Repositories\Interfaces\MediaLibraryRepositoryInterface;
use App\Modules\MediaLibarary\Services\Implementations\MediaLibraryService;
use App\Modules\MediaLibarary\Services\Interfaces\MediaLibraryServiceInterface;
use Illuminate\Support\ServiceProvider;

class MediaLibararyServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Service bindings
        $this->app->bind(
            MediaLibraryRepositoryInterface::class,
            MediaLibraryRepository::class
        );

        $this->app->bind(
            MediaLibraryServiceInterface::class,
            MediaLibraryService::class
        );

        $this->mergeConfigFrom(__DIR__ . '/../Config/medialibarary.php', 'medialibarary');
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'medialibarary');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
}
