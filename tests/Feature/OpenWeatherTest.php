<?php

namespace Tests\Feature;

use App\Services\WeatherService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class OpenWeatherTest extends TestCase
{
    /**
     * This test make sure if Service method can fetch and format the current weather
     */
    public function test_it_can_fetch_and_format_current_weather(): void
    {
        Http::fake([
            'api.openweather.org/*' => Http::response(
                body: [
                    'main' => ['temp' => 23.0],
                    'weather' => [
                        [
                            'main' => 'Clouds',
                            'description' => 'nublado'
                        ]
                    ]
                ],
                status: Response::HTTP_OK
            )
        ]);

        $service = app(WeatherService::class);
        $result = $service->getCurrentWeather();

        $this->assertIsArray($result);
        $this->assertEquals(23.0, $result['temperature']);
        $this->assertEquals('Clouds', $result['condition']);
        $this->assertEquals('nublado', $result['description']);
    }

    public function test_it_returns_null_when_api_fails(): void 
    {
        Http::fake(['api.openweather.org/*' => Http::response([], 500)]);

        $service = app(WeatherService::class);
        $result = $service->getCurrentWeather();

        $this->assertNull($result);
    }
}
