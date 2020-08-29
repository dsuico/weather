<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class WeatherServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('openweathermap', function ($app) {
            return new \App\Core\API\OpenWeatherMap;
        });
        $this->app->bind('weatherstack', function ($app) {
            return new \App\Core\API\WeatherStack;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
