<?php

namespace WebGarden\UrlShortener;

use Illuminate\Support\ServiceProvider;
use WebGarden\UrlShortener\Console\Commands\ExpandUrl;
use WebGarden\UrlShortener\Console\Commands\ShortenUrl;

class LaravelServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/shortener.php' => config_path('shortener.php'),
        ], 'config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                ExpandUrl::class,
                ShortenUrl::class,
            ]);
        }
    }
}
