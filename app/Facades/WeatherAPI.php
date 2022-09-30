<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class WeatherAPI extends Facade {

    /**
     * @method static void get()
     *
     * @see \App\API\WeatherAPI
     */

    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'WeatherAPI';
    }
}
