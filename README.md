# URL Shortener
[![Build Status](https://travis-ci.org/andrzejkupczyk/url-shortener.svg?branch=master)](https://travis-ci.org/andrzejkupczyk/url-shortener) 
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/andrzejkupczyk/url-shortener/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/andrzejkupczyk/url-shortener/?branch=master)
![PHP requirement](https://img.shields.io/badge/PHP-^7.1-blue.svg)

A simple yet easily extendable library to generate shortened URLs using different providers: 
[Firebase Dynamic Links](https://firebase.google.com/docs/dynamic-links/), [Google URL Shortener](https://goo.gl) and [TinyURL](https://tinyurl.com/). 
A simple database-based provider is available as well.

## Install
Via Composer
```
composer require andrzejkupczyk/url-shortener
```

## Examples of use

### Creating short URLs
```php
$shortener = UrlShortener::google('AIzaSyBkl6ihyPByyE5lmK03z7XN-1G0YfXjtj8');
$link = $shortener->shorten(new Url('https://github.com/andrzejkupczyk/url-shortener'));

var_dump((string) $link->shortUrl()); // string(21) "https://goo.gl/KPUFBm"
```

### Expanding shortened URLs
```php
$shortener = UrlShortener::google('AIzaSyBkl6ihyPByyE5lmK03z7XN-1G0YfXjtj8');
$link = $shortener->expand(new Url('https://goo.gl/KPUFBm'));

var_dump((string) $link->longUrl()); // string(47) "https://github.com/andrzejkupczyk/url-shortener"
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
