<?php

namespace App\Providers;

use App\Services\SiteSettings;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', static function ($view): void {
            $view->with('siteSettings', app(SiteSettings::class)->all());
        });
    }
}
