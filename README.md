# URL Shortener
[![Build Status](https://travis-ci.org/andrzejkupczyk/url-shortener.svg?branch=master)](https://travis-ci.org/andrzejkupczyk/url-shortener) 
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/andrzejkupczyk/url-shortener/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/andrzejkupczyk/url-shortener/?branch=master)
![PHP requirement](https://img.shields.io/badge/PHP-^7.1-blue.svg)

A simple yet easily extendable library to generate shortened URLs using different providers: 
[Bitly](https://bit.ly/), [Firebase Dynamic Links](https://firebase.google.com/docs/dynamic-links/) and [TinyURL](https://tinyurl.com/).

## Install
Via Composer
```
composer require andrzejkupczyk/url-shortener
```

## Examples of use

### Creating short URLs
```php
$shortener = UrlShortener::bitly('7dc770e7e42d6d24b490d392201a85d9b3bbbdcd');
$link = $shortener->shorten(new Url('https://github.com/andrzejkupczyk/url-shortener'));

print($link->shortUrl()); // http://bit.ly/2Dkm8SJ
```

### Expanding shortened URLs
```php
$shortener = UrlShortener::bitly('7dc770e7e42d6d24b490d392201a85d9b3bbbdcd');
$link = $shortener->expand(new Url('http://bit.ly/2Dkm8SJ'));

print($link->longUrl()); // https://github.com/andrzejkupczyk/url-shortener
```

## Laravel support
It is possible to use this package within a Laravel >=5.5 application (it is configured for discovery).

### Configuration  
Publish and modify the configuration file:
```
php artisan vendor:publish --provider="WebGarden\UrlShortener\LaravelServiceProvider"
```
### Artisan commands
```
url:expand {url}   Expand short URL
url:shorten {url}  Shorten long URL
```
