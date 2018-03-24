# URL Shortener
[![Build Status](https://travis-ci.org/andrzejkupczyk/url-shortener.svg?branch=master)](https://travis-ci.org/andrzejkupczyk/url-shortener) ![](https://img.shields.io/badge/php-^7.0-blue.svg)

A simple yet easily extendable library to generate shortened URLs using different providers: 
[Google URL Shortener](https://goo.gl) and [TinyURL](https://tinyurl.com/). 
A simple database-based provider is available as well.

## Install
Via Composer
```
composer require andrzejkupczyk/url-shortener:1.0.x
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
