<?php

namespace App\Providers;

use App\Services\WeatherService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(WeatherService::class, function ($app) {
            return new WeatherService(
                api_key: config('services.openweather.key'),
                city: config('services.openweather.city'),
                lang: config('services.openweather.lang')
            );
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
