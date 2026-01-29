<?php

namespace App\Http\Controllers;

use App\Services\SMSService;
use App\Services\WeatherService;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function weather(Request $request, WeatherService $weather)
    {
        $lat = $request->lat;
        $lng = $request->lng;

        if (!$lat || !$lng) {
            return response()->json([
                'status' => 'error',
                'message' => 'Latitude & Longitude required'
            ], 400);
        }

        $data = $weather->getWeatherByLatLng($lat, $lng);

        return response()->json([
            'status'      => 'success',
            'city'        => $data['name'] ?? 'Unknown',
            'temperature' => $data['main']['temp'],
            'description' => $data['weather'][0]['description'],
            'humidity'    => $data['main']['humidity'],
            'wind_speed'  => $data['wind']['speed'],
        ]);
    }
   
}

