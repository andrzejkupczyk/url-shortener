<?php

declare(strict_types=1);

namespace WebGarden\UrlShortener\Laravel;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use WebGarden\UrlShortener\Console\Commands\ExpandUrl;
use WebGarden\UrlShortener\Console\Commands\ShortenUrl;

class ServiceProvider extends BaseServiceProvider
{
    public function boot(): void
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
