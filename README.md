# URL Shortener (beta)
A simple yet easily extendable library to generate shortened URLs using different providers: 
[Google URL Shortener](https://goo.gl) and [TinyURL](https://tinyurl.com/). 
A simple database-based provider is available as well.

## Minimum requirements
- PHP >=7.0

## Install
Via Composer
```
composer require andrzejkupczyk/url-shortener:@dev
```

## Laravel 5.5 support
It is possible to use this package within a Laravel application (it is configured for discovery).

### Configuration  
Publish and modify the configuration file:
```
php artisan vendor:publish --provider="WebGarden\UrlShortener\LaravelServiceProvider"
```

### Database provider
To make it work you'll need to run migration:
```
php artisan migrate
```

### Artisan commands
```
url:expand {url}   Expand short URL
url:shorten {url}  Shorten long URL
```
