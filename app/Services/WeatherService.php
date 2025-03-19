<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;

class WeatherService
{
    protected $apiKey;
    protected $city;

    public function __construct()
    {
        $this->apiKey = config('services.openweathermap.key');
        $this->city = config('services.openweathermap.city', 'Rome');
    }

    protected function getLocationFromIP()
    {
        $ip = Request::ip();
        
        // Cache location data for 24 hours
        return Cache::remember('location_' . $ip, 86400, function () use ($ip) {
            try {
                $response = Http::get("http://ip-api.com/json/{$ip}");
                
                if ($response->successful()) {
                    $data = $response->json();
                    if ($data['status'] === 'success') {
                        return [
                            'city' => $data['city'],
                            'country' => $data['countryCode'],
                            'lat' => $data['lat'],
                            'lon' => $data['lon']
                        ];
                    }
                }
                
                // Fallback to default location if API fails
                return [
                    'city' => 'Rome',
                    'country' => 'IT',
                    'lat' => 41.9028,
                    'lon' => 12.4964
                ];
            } catch (\Exception $e) {
                // Fallback to default location if any error occurs
                return [
                    'city' => 'Rome',
                    'country' => 'IT',
                    'lat' => 41.9028,
                    'lon' => 12.4964
                ];
            }
        });
    }

    public function getWeatherData()
    {
        return Cache::remember('weather_data', 1800, function () {
            try {
                $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
                    'q' => $this->city,
                    'appid' => $this->apiKey,
                    'units' => 'metric'
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    return [
                        'temperature' => round($data['main']['temp']),
                        'feels_like' => round($data['main']['feels_like']),
                        'humidity' => $data['main']['humidity'],
                        'pressure' => $data['main']['pressure'],
                        'wind_speed' => round($data['wind']['speed'] * 3.6, 1), // Convert m/s to km/h
                        'description' => ucfirst($data['weather'][0]['description']),
                        'icon' => $data['weather'][0]['icon'],
                        'city' => $data['name'],
                        'country' => $data['sys']['country']
                    ];
                }
            } catch (\Exception $e) {
                \Log::error('Weather API Error: ' . $e->getMessage());
            }

            return null;
        });
    }

    public function getWeatherIcon($code)
    {
        return match (substr($code, 0, 2)) {
            '01' => 'fa-sun',
            '02' => 'fa-cloud-sun',
            '03', '04' => 'fa-cloud',
            '09', '10' => 'fa-cloud-showers-heavy',
            '11' => 'fa-bolt',
            '13' => 'fa-snowflake',
            '50' => 'fa-smog',
            default => 'fa-cloud',
        };
    }
} 