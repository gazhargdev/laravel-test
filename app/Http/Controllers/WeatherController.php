<?php

namespace App\Http\Controllers;

use App\Facades\WeatherAPI;
use App\Http\Resources\WeatherResource;
use Illuminate\Http\Request;


class WeatherController extends Controller
{
    public function getWeather(Request $request)
    {
        // Validate request
        $request->validate([
            'search' => 'required|string'
        ]);

        // Call the API and store response in variable
        $response = WeatherAPI::get($request->search);

        // Return custom JSON using Resource
        return WeatherResource::make(json_decode($response->body(), true))->resolve();
    }
}
