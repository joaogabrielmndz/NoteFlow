<?php

namespace App\Strategies\Weather\Api;

use App\Strategies\Weather\Contracts\ApiWeatherStrategyInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Override;

class OpenMeteoStrategy implements ApiWeatherStrategyInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected string $city,
        protected string $lang
    ) {}

    /**
     * Get the city coordinates, its util if you dont know your city coordinates
     * @return ?array
     */
    public function getCityCoordinates(): ?array 
    {
        $response = Http::get('https://geocoding-api.open-meteo.com/v1/search', [
            'name' => $this->city,
            'count' => 1,
            'language' => $this->lang,
            'format' => 'json'
        ]);

        if ($response->successful() && !empty($response->json('results')))
            return  [
                'longitude' => $response->json('results.0.longitude'),
                'latitude' => $response->json('results.0.latitude'),
                'timezone' => $response->json('results.0.timezone')
            ];

        return null;
    }

    #[Override]
    public function getCurrentWeather(): ?array
    {
        $coords = $this->getCityCoordinates();

        if (!$coords) return throw new InvalidArgumentException("Coordenadas vazias");

        $response = Http::get('https://api.open-meteo.com/v1/forecast', [
            'latitude' => $coords['latitude'],
            'longitude' => $coords['longitude'],
            'current' => 'weather_code, temperature_2m',
            'timezone' => $coords['timezone'],
            'forecast_days' => 1 // (today)
        ]);

        if ($response->successful()) 
            return [
                'current' => [
                    'temperature_min' => (float) ceil($response->json('current.temperature_2m.0')),
                    'weather_code' => $response->json('current.weather_code.0'),
                ],
            ];

        return null;
    }

    #[Override]
    public function getDailyForecast(): ?array
    {
        $coords = $this->getCityCoordinates();

        $response = Http::get('https://api.open-meteo.com/v1/forecast', [
            'latitude' => $coords['latitude'],
            'longitude' => $coords['longitude'],
            'daily' => 'weather_code,temperature_2m_max,temperature_2m_min',
            'timezone' => $coords['timezone'],
            'forecast_days' => 2 // (today, tomorrow)
        ]);

        if ($response->successful()) 
            return [
                'today' => [
                    'temperature_min' => (float) ceil($response->json('daily.temperature_2m_min.0')),
                    'temperature_max' => (float) ceil($response->json('daily.temperature_2m_max.0')),
                    'weather_code' => $response->json('daily.weather_code.0'),
                ],
                'tomorrow' => [
                    'temperature_min' => $response->json('daily.temperature_2m_min.1'),
                    'temperature_max' => $response->json('daily.temperature_2m_max.1'),
                    'weather_code' => $response->json('daily.weather_code.1'),
                ]
            ];

        return null;
    }

    
}
