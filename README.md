# URL Shortener
![PHP requirement](https://img.shields.io/badge/PHP-^7.3-blue.svg?logo=php&style=for-the-badge)
![Build status](https://img.shields.io/travis/andrzejkupczyk/url-shortener/master?logo=travis&style=for-the-badge)
![Code quality](https://img.shields.io/scrutinizer/quality/g/andrzejkupczyk/url-shortener?logo=scrutinizer&style=for-the-badge)

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
