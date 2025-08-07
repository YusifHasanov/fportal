<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // SEO ve diğer servisleri kaydet
        $this->app->singleton(\App\Services\SeoService::class);
        $this->app->singleton(\App\Services\ImageOptimizationService::class);
        $this->app->singleton(\App\Services\CacheService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // URL'lerde HTTPS zorla (production için)
        if (config('app.env') === 'production') {
            \URL::forceScheme('https');
        }

        // Model observers
        \App\Models\News::observe(\App\Observers\NewsObserver::class);
    }
}
