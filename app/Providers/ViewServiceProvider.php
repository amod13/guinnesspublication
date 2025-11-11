<?php

namespace App\Providers;

use App\View\Composers\CommonDataPrepareforWeb;
use App\View\Composers\UserComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Register user composer
        View::composer('*', UserComposer::class);
        View::composer('*', CommonDataPrepareforWeb::class);
    }
}
