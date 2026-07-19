<?php

namespace App\Services;

use App\Ai\Agents\Flow;
use App\Strategies\Weather\ApiWeatherContext;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class SuggestionService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public ApiWeatherContext $context
    ) {}

    public function getDiagnostic()
    {
        $weatherData = $this->context->getCurrentWeather();

        if (!$weatherData) throw new RuntimeException("Falha ao capturar a API de clima");

        $temperature = $weatherData['current']['temperature'];

        $agent_response = Flow::make($temperature)
            ->prompt("Qual a temperatura?");

        Log::info("Teste de diagnostico com Flow executado", ['ia_response' => $agent_response]);

        return (string) $agent_response;
    }
}
