<?php

namespace WebGarden\UrlShortener\Providers;

use WebGarden\UrlShortener\Model\ValueObjects\Domain;

class Factory
{
    public static function bitly(string $apiKey, string $domain)
    {
        return new Bitly\BitlyProvider($apiKey, Domain::fromNative($domain));
    }

    public static function firebase(string $apiKey, string $dynamicLinkDomain)
    {
        return new Google\FirebaseProvider($apiKey, Domain::fromNative($dynamicLinkDomain));
    }

    public static function tinyUrl(string $apiKey): Provider
    {
        return new TinyUrl\TinyUrlProvider($apiKey);
    }
}
