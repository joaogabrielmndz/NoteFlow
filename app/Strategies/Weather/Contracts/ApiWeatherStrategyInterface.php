<?php

namespace App\Strategies\Weather\Contracts;

interface ApiWeatherStrategyInterface
{
    /**
     * Returns a array of current weather
     * @return ?array
     */
    public function getCurrentWeather(): ?array;

    /**
     * Returns a array of the daily forecast
     * @return ?array
     */
    public function getDailyForecast(): ?array;
}