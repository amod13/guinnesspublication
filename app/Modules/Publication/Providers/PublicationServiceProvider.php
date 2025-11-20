<?php

namespace App\Modules\Publication\Providers;

use App\Modules\Publication\Repositories\Implementations\AboutUsRepository;
use App\Modules\Publication\Repositories\Implementations\AuthorsRepository;
use App\Modules\Publication\Repositories\Implementations\BlogCategoryRepository;
use App\Modules\Publication\Repositories\Implementations\BlogRepository;
use App\Modules\Publication\Repositories\Implementations\BookCategoriesRepository;
use App\Modules\Publication\Repositories\Implementations\BookRepository;
use App\Modules\Publication\Repositories\Implementations\DealersRepository;
use App\Modules\Publication\Repositories\Implementations\GalleryCategoryRepository;
use App\Modules\Publication\Repositories\Implementations\GalleryRepository;
use App\Modules\Publication\Repositories\Implementations\MarketingsRepository;
use App\Modules\Publication\Repositories\Implementations\PageRepository;
use App\Modules\Publication\Repositories\Implementations\SettingRepository;
use App\Modules\Publication\Repositories\Implementations\SliderRepository;
use App\Modules\Publication\Repositories\Implementations\VmgRepository;
use App\Modules\Publication\Repositories\Interfaces\AboutUsRepositoryInterface;
use App\Modules\Publication\Repositories\Interfaces\AuthorsRepositoryInterface;
use App\Modules\Publication\Repositories\Interfaces\BlogCategoryRepositoryInterface;
use App\Modules\Publication\Repositories\Interfaces\BlogRepositoryInterface;
use App\Modules\Publication\Repositories\Interfaces\BookCategoriesRepositoryInterface;
use App\Modules\Publication\Repositories\Interfaces\BookRepositoryInterface;
use App\Modules\Publication\Repositories\Interfaces\DealersRepositoryInterface;
use App\Modules\Publication\Repositories\Interfaces\GalleryCategoryRepositoryInterface;
use App\Modules\Publication\Repositories\Interfaces\GalleryRepositoryInterface;
use App\Modules\Publication\Repositories\Interfaces\MarketingsRepositoryInterface;
use App\Modules\Publication\Repositories\Interfaces\PageRepositoryInterface;
use App\Modules\Publication\Repositories\Interfaces\SettingRepositoryInterface;
use App\Modules\Publication\Repositories\Interfaces\SliderRepositoryInterface;
use App\Modules\Publication\Repositories\Interfaces\VmgRepositoryInterface;
use App\Modules\Publication\Services\Implementations\AboutUsService;
use App\Modules\Publication\Services\Implementations\AuthorsService;
use App\Modules\Publication\Services\Implementations\BlogCategoryService;
use App\Modules\Publication\Services\Implementations\BlogService;
use App\Modules\Publication\Services\Implementations\BookCategoriesService;
use App\Modules\Publication\Services\Implementations\BookService;
use App\Modules\Publication\Services\Implementations\DealersService;
use App\Modules\Publication\Services\Implementations\GalleryCategoryService;
use App\Modules\Publication\Services\Implementations\GalleryService;
use App\Modules\Publication\Services\Implementations\MarketingsService;
use App\Modules\Publication\Services\Implementations\PageService;
use App\Modules\Publication\Services\Implementations\SettingService;
use App\Modules\Publication\Services\Implementations\SliderService;
use App\Modules\Publication\Services\Implementations\VmgService;
use App\Modules\Publication\Services\Interfaces\AboutUsServiceInterface;
use App\Modules\Publication\Services\Interfaces\AuthorsServiceInterface;
use App\Modules\Publication\Services\Interfaces\BlogCategoryServiceInterface;
use App\Modules\Publication\Services\Interfaces\BlogServiceInterface;
use App\Modules\Publication\Services\Interfaces\BookCategoriesServiceInterface;
use App\Modules\Publication\Services\Interfaces\BookServiceInterface;
use App\Modules\Publication\Services\Interfaces\DealersServiceInterface;
use App\Modules\Publication\Services\Interfaces\GalleryCategoryServiceInterface;
use App\Modules\Publication\Services\Interfaces\GalleryServiceInterface;
use App\Modules\Publication\Services\Interfaces\MarketingsServiceInterface;
use App\Modules\Publication\Services\Interfaces\PageServiceInterface;
use App\Modules\Publication\Services\Interfaces\SettingServiceInterface;
use App\Modules\Publication\Services\Interfaces\SliderServiceInterface;
use App\Modules\Publication\Services\Interfaces\VmgServiceInterface;
use Illuminate\Support\ServiceProvider;

class PublicationServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Service bindings will be added here
        $this->mergeConfigFrom(__DIR__ . '/../Config/publication.php', 'publication');

        // Service Bindings
        $this->app->bind(SettingServiceInterface::class, SettingService::class);
        $this->app->bind(PageServiceInterface::class, PageService::class);
        $this->app->bind(BookCategoriesServiceInterface::class, BookCategoriesService::class);
        $this->app->bind(BookServiceInterface::class, BookService::class);
        $this->app->bind(SliderServiceInterface::class, SliderService::class);
        $this->app->bind(AboutUsServiceInterface::class, AboutUsService::class);
        $this->app->bind(GalleryCategoryServiceInterface::class, GalleryCategoryService::class);
        $this->app->bind(GalleryServiceInterface::class, GalleryService::class);
        $this->app->bind(AuthorsServiceInterface::class, AuthorsService::class);
        $this->app->bind(VmgServiceInterface::class, VmgService::class);
        $this->app->bind(BlogCategoryServiceInterface::class, BlogCategoryService::class);
        $this->app->bind(BlogServiceInterface::class, BlogService::class);

        // Repository Bindings
        $this->app->bind(SettingRepositoryInterface::class, SettingRepository::class);
        $this->app->bind(PageRepositoryInterface::class, PageRepository::class);
        $this->app->bind(BookCategoriesRepositoryInterface::class, BookCategoriesRepository::class);
        $this->app->bind(BookRepositoryInterface::class, BookRepository::class);
        $this->app->bind(SliderRepositoryInterface::class, SliderRepository::class);
        $this->app->bind(AboutUsRepositoryInterface::class, AboutUsRepository::class);
        $this->app->bind(MarketingsServiceInterface::class, MarketingsService::class);
        $this->app->bind(MarketingsRepositoryInterface::class, MarketingsRepository::class);
        $this->app->bind(DealersServiceInterface::class, DealersService::class);
        $this->app->bind(DealersRepositoryInterface::class, DealersRepository::class);
        $this->app->bind(GalleryCategoryRepositoryInterface::class, GalleryCategoryRepository::class);
        $this->app->bind(GalleryRepositoryInterface::class, GalleryRepository::class);
        $this->app->bind(AuthorsRepositoryInterface::class, AuthorsRepository::class);
        $this->app->bind(VmgRepositoryInterface::class, VmgRepository::class);
        $this->app->bind(BlogCategoryRepositoryInterface::class, BlogCategoryRepository::class);
        $this->app->bind(BlogRepositoryInterface::class, BlogRepository::class);
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/site.php');
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'publication');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
}
