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
        $precipitation =[];
        $wind_Speed =[];
        $humidity = [];

        foreach ($data['list'] as $weatherData) {
            $labels[] = date('d H:i', $weatherData['dt']);
            $temperatures[] = $weatherData['main']['temp'];
            $precipitation[] = $weatherData['rain']['3h']?? 0;
            $wind_Speed[] = $weatherData['wind']['speed']?? 0;
            $humidity[] = $weatherData['main']['humidity']??0;
        }

        return view('weather-chart', ['data' => ['labels' => $labels, 'temperatures' => $temperatures, 'precipitation'=> $precipitation, 'wind_Speed'=> $wind_Speed, 'humidity'=> $humidity ]]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
    }
}


    }
