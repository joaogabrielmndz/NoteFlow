<?php

namespace App\Strategies\Weather;

use App\Strategies\Weather\Contracts\ApiWeatherStrategyInterface;

class ApiWeatherContext
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public ApiWeatherStrategyInterface $strategy
    ) {}

    public function setStrategy(ApiWeatherStrategyInterface $strategy)
    {
        $this->$strategy = $strategy;
    }

    public function getCurrentWeather()
    {
        return $this->strategy->getCurrentWeather();
    }

    public function getDailyForecast()
    {
        return $this->strategy->getDailyForecast();
    }
}
