<?php

namespace WebGarden\UrlShortener\Providers;

use Illuminate\Database\Query\Builder;
use WebGarden\UrlShortener\Model\ValueObjects\Domain;
use WebGarden\UrlShortener\Model\ValueObjects\Url;

class Factory
{
    public static function eloquent(Url $baseUrl, Builder $query): Provider
    {
        return new Database\EloquentProvider($baseUrl, $query);
    }

    public static function firebase(string $apiKey, string $dynamicLinkDomain)
    {
        return new Google\FirebaseProvider($apiKey, Domain::fromNative($dynamicLinkDomain));
    }

    public static function google(string $apiKey): Provider
    {
        return new Google\GoogleProvider($apiKey);
    }

    public static function tinyUrl(string $apiKey): Provider
    {
        return new TinyUrl\TinyUrlProvider($apiKey);
    }
}
