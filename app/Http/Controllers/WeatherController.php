<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function getWeatherData(Request $request)
{
    $apiKey = '261d4c8305f6693860e215b6d31c4701';
    $city = 'Valmiera';
    $apiUrl = "https://api.openweathermap.org/data/2.5/forecast?q={$city}&appid={$apiKey}";

    try {
        $response = Http::get($apiUrl);
        $data = $response->json();

        $labels = [];
        $temperatures = [];

        foreach ($data['list'] as $weatherData) {
            $labels[] = date('Y-m-d H:i:s', $weatherData['dt']);
            $temperatures[] = $weatherData['main']['temp'];
        }

        return view('weather-chart', ['data' => ['labels' => $labels, 'temperatures' => $temperatures]]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
    }
}


    }
