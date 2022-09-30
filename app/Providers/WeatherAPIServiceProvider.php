<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class WeatherAPIServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('WeatherAPI', \App\API\WeatherAPI::class);
    }

}
