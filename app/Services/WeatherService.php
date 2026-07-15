<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected string $api_key,
        protected string $city,
        protected string $lang
    ) {
    }

    public function getCurrentWeather(): ?array
    {
        $response = Http::get(
            'https://api.openweathermap.org/data/2.5/weather',
            query: [
                'q' => $this->city,
                'appid' => $this->api_key,
                'units' => 'metric',
                'lang' => $this->lang
            ]
        );

        Log::debug("Response capturado:\n {$response}");
        if ($response->successful()) {
            return [
                'temperature' => (float) round($response->json('main.temp')),
                'condition' => $response->json('weather.0.main'),
                'description' => $response->json('weather.0.description'),
            ];
        }

        return null;
    }
}
