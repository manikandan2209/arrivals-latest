<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Pim\Plytix;
use App\Influence\Influence;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind('plytix', function()
        {
            return new Plytix();
        });

        // Register the Influence service
        // This allows you to use the Influence facade in your application
        // and access methods defined in the Influence class.
        $this->app->bind('influence', function()
        {
            return new Influence();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
