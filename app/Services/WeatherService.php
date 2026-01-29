<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{
    public function getWeatherByLatLng($lat, $lng)
    {
        return Http::get('https://api.openweathermap.org/data/2.5/weather', [
            'lat'   => $lat,
            'lon'   => $lng,
            'appid'=> config('services.weather.key'),
            'units'=> 'metric',
        ])->json();
    }
}
