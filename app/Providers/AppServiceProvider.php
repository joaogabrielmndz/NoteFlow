<?php

namespace App\Providers;

use App\Strategies\Weather\Api\OpenMeteoStrategy;
use App\Strategies\Weather\ApiWeatherContext;
use App\Strategies\Weather\Contracts\ApiWeatherStrategyInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('api_meteo', function ($app) {
            return new OpenMeteoStrategy(
                city: 'Porto Alegre', // variaveis predefinidas (temporario)
                lang: 'pt'
            );
        });

        $this->app->bind(ApiWeatherContext::class, function ($app) {
            return new ApiWeatherContext($app->make('api_meteo'));
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
