<?php

namespace App\API;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class WeatherAPI
{
    protected $url;
    protected $key;
    protected $input;

    public function __construct()
    {
        $this->url = env('WEATHER_API_URI');
        $this->key = env('WEATHER_API_KEY');
    }

    /**
     * Make and return the API call
     *
     * @param $input
     * @return Response
     */
    public function get($input)
    {
        return Http::accept('application/json')->get($this->buildURI($input));
    }

    /**
     * Build the API URL
     *
     * @param $input
     * @return string
     */
    protected function buildURI($input)
    {
        return $this->url . '/v1/current.json?key=' . $this->key . '&q=' . $input . '&aqi=no';
    }
}
