<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Schema;

use Cache;
use Illuminate\Support\Facades\Cache as FacadesCache;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Builder::defaultStringLength(191);
        if (Schema::hasTable('site')) {
            FacadesCache::forever('site', \App\Models\Site::first());
            sidebar_title();
        }
    }
}
