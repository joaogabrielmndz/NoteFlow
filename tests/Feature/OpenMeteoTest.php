<?php

namespace Tests\Feature;

use App\Strategies\Weather\Api\OpenMeteoStrategy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class OpenMeteoTest extends TestCase
{
   /**
     * Testa se o método de coordenadas extrai os dados corretos do JSON.
     */
    public function test_it_fetches_city_coordinates_correctly(): void
    {
        Http::fake([
            'geocoding-api.open-meteo.com/v1/search*' => Http::response([
                'results' => [
                    [
                        'latitude' => -30.0331,
                        'longitude' => -51.2300,
                        'timezone' => 'America/Sao_Paulo'
                    ]
                ]
            ], 200)
        ]);

        $strategy = new OpenMeteoStrategy('Porto Alegre', 'pt');
        $coords = $strategy->getCityCoordinates();

        $this->assertIsArray($coords);
        $this->assertEquals(-30.0331, $coords['latitude']);
        $this->assertEquals(-51.2300, $coords['longitude']);
    }

    /**
     * Testa se o pacote final de previsão diária monta o array correto de Hoje e Amanhã.
     */
    public function test_it_returns_daily_forecast_for_today_and_tomorrow(): void
    {
        Http::fake([
            'https://geocoding-api.open-meteo.com/v1/search*' => Http::response([
                'results' => [
                    ['latitude' => -30.0, 'longitude' => -51.0, 'timezone' => 'America/Sao_Paulo']
                ]
            ], 200),
            
            'https://api.open-meteo.com/v1/forecast*' => Http::response([
                'daily' => [
                    'temperature_2m_min' => [10.5, 12.0],
                    'temperature_2m_max' => [25.0, 27.5],
                    'weather_code' => [3, 61], // 3 = Nublado, 61 = Chuva
                ]
            ], 200)
        ]);

        $strategy = new OpenMeteoStrategy('Porto Alegre', 'pt');
        $forecast = $strategy->getDailyForecast();

        $this->assertNotNull($forecast);
        
        /** Today */
        $this->assertEquals(11.0, $forecast['today']['temperature_min']);
        $this->assertEquals(25.0, $forecast['today']['temperature_max']);
        $this->assertEquals(3, $forecast['today']['weather_code']);
        
        /** Tomorrow */
        $this->assertEquals(12.0, $forecast['tomorrow']['temperature_min']);
        $this->assertEquals(27.5, $forecast['tomorrow']['temperature_max']);
        $this->assertEquals(61, $forecast['tomorrow']['weather_code']);
    }
}
