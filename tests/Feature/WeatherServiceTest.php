<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\WeatherService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WeatherServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected $weatherService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->weatherService = new WeatherService();
    }

    /** @test */
    public function it_can_fetch_weather_data()
    {
        // Mock the HTTP call to OpenWeatherMap API
        Http::fake([
            'api.openweathermap.org/data/2.5/weather*' => Http::response([
                'weather' => [['id' => 800, 'main' => 'Clear', 'description' => 'clear sky', 'icon' => '01d']],
                'main' => [
                    'temp' => 20, // Already in Celsius
                    'feels_like' => 19,
                    'pressure' => 1013,
                    'humidity' => 65
                ],
                'wind' => ['speed' => 5.1],
                'name' => 'Test City',
                'sys' => ['country' => 'IT']
            ], 200)
        ]);

        $weather = $this->weatherService->getWeatherData();

        $this->assertIsArray($weather);
        $this->assertEquals('Test City', $weather['city']);
        $this->assertEquals('IT', $weather['country']);
        $this->assertEquals(20, $weather['temperature']);
        $this->assertEquals(65, $weather['humidity']);
    }

    /** @test */
    public function it_handles_api_error_gracefully()
    {
        Http::fake([
            'api.openweathermap.org/data/2.5/weather*' => Http::response([], 500)
        ]);

        $weather = $this->weatherService->getWeatherData();

        $this->assertNull($weather);
    }

    /** @test */
    public function it_caches_weather_data()
    {
        Cache::flush();

        Http::fake([
            'api.openweathermap.org/data/2.5/weather*' => Http::response([
                'weather' => [['id' => 800, 'main' => 'Clear', 'description' => 'clear sky', 'icon' => '01d']],
                'main' => [
                    'temp' => 293.15,
                    'feels_like' => 292.15,
                    'pressure' => 1013,
                    'humidity' => 65
                ],
                'wind' => ['speed' => 5.1],
                'name' => 'Test City',
                'sys' => ['country' => 'IT']
            ], 200)
        ]);

        // First call should hit the API
        $this->weatherService->getWeatherData();

        // Second call should use cached data
        $this->weatherService->getWeatherData();

        Http::assertSentCount(1);
    }

    /** @test */
    public function it_returns_correct_weather_icon()
    {
        $testCases = [
            '01d' => 'fa-sun',
            '02d' => 'fa-cloud-sun',
            '03d' => 'fa-cloud',
            '04d' => 'fa-cloud',
            '09d' => 'fa-cloud-showers-heavy',
            '10d' => 'fa-cloud-showers-heavy',
            '11d' => 'fa-bolt',
            '13d' => 'fa-snowflake',
            '50d' => 'fa-smog'
        ];

        foreach ($testCases as $code => $expected) {
            $icon = $this->weatherService->getWeatherIcon($code);
            $this->assertEquals($expected, $icon);
        }
    }
} 