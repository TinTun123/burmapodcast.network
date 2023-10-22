<?php

namespace App\Providers;

use App\Services\Statistic;
use Illuminate\Support\ServiceProvider;

class StasticServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        $this->app->bind(Statistic::class, function ($app) {
            return new Statistic();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
