<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $city = request('city', 'Kuressaare');

        return Inertia::render('Dashboard', [
            'weather' => Cache::remember('weather-'.$city, now()->addHour(), fn () => $this->getWeatherData($city))
        ]);
    }

    private function getWeatherData(string $city) 
    {
        $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
            'q' => 'Kuressaare',
            'units' => 'metric',
            'appid' => config('services.open_weather_app.key')
        ]);

        return $response->json();
    }
}
