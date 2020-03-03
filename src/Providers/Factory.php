<?php

namespace WebGarden\UrlShortener\Providers;

use WebGarden\UrlShortener\Clients\Http\HttpClient;
use WebGarden\UrlShortener\Clients\Http\Middleware\AddOAuthToken;
use WebGarden\UrlShortener\Model\ValueObjects\Domain;

/**
 * @internal the class is used by the UrlShortener to instantiate itself using static calls
 */
class Factory
{
    public static function bitly(string $apiUri, string $apiKey, string $domain): Provider
    {
        $client = new HttpClient($apiUri);
        $client->pushMiddleware(new AddOAuthToken($apiKey));

        return new Bitly\BitlyProvider($client, Domain::fromNative($domain));
    }

    public static function firebase(string $apiUri, string $apiKey, string $dynamicLinkDomain): Provider
    {
        $client = new HttpClient($apiUri);

        return new Google\FirebaseProvider($client, $apiKey, Domain::fromNative($dynamicLinkDomain));
    }

    public static function tinyUrl(string $apiUri, string $apiKey): Provider
    {
        $client = new HttpClient($apiUri);

        return new TinyUrl\TinyUrlProvider($client, $apiKey);
    }
}
