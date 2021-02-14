# URL Shortener

![PHP requirement](https://img.shields.io/packagist/php-v/andrzejkupczyk/url-shortener?logo=php&style=for-the-badge)
![Build status](https://img.shields.io/travis/andrzejkupczyk/url-shortener/master?logo=travis&style=for-the-badge)
![Code quality](https://img.shields.io/scrutinizer/quality/g/andrzejkupczyk/url-shortener?logo=scrutinizer&style=for-the-badge)

A simple yet easily extendable library to generate [shortened URLs](https://en.wikipedia.org/wiki/URL_shortening) using different providers.

## Install

Via Composer
```
composer require andrzejkupczyk/url-shortener
```

## Examples of use

### Creating short URLs

```php
$shortener = UrlShortener::bitly($apiUri, $apiKey);

$link = $shortener->shorten(new Url('https://github.com/andrzejkupczyk/url-shortener'));

print($link->shortUrl()); // http://bit.ly/2Dkm8SJ
```

### Expanding shortened URLs

```php
$shortener = UrlShortener::bitly($apiUri, $apiKey);

$link = $shortener->expand(new Url('http://bit.ly/2Dkm8SJ'));

print($link->longUrl()); // https://github.com/andrzejkupczyk/url-shortener
```

## Supported providers

| | Shortening | Expanding | Branding |
| --- | :---: | :---: | :---: |
| [Bitly](https://bit.ly/) | ✔️ | ✔️ | ✔️ |
| [Firebase Dynamic Links](https://firebase.google.com/docs/dynamic-links/)  | ✔️ | ❌ | ✔️ |
| [TinyURL](https://tinyurl.com/) | ✔️ | ❌ | ❌ |

## Laravel support
It is possible to use this package easily within a Laravel >=5.5 application (it is configured for discovery).

### Artisan commands

```bash
url:expand {url}   Expand short URL
url:shorten {url}  Shorten long URL
```

### Configuration (not required)  

Publish and modify the configuration file:
```
php artisan vendor:publish --provider="WebGarden\UrlShortener\LaravelServiceProvider"
```

