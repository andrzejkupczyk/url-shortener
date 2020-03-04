<?php

namespace WebGarden\UrlShortener\Providers;

use WebGarden\UrlShortener\Clients\Http\HttpClient;
use WebGarden\UrlShortener\Clients\Http\Middleware\AddOAuthToken;
use WebGarden\UrlShortener\Model\ValueObjects\Domain;

/**
 * @internal the class is used by the UrlShortener to instantiate itself using static calls
 */
final class Factory
{
    public static function bitly(string $apiUri, string $apiKey, ?string $domain = null): Provider
    {
        $client = new HttpClient($apiUri);
        $client->pushMiddleware(new AddOAuthToken($apiKey));

        if ($domain === null) {
            return new Bitly\BitlyProvider($client);
        }

        return new Bitly\BitlyProvider($client, new Domain($domain));
    }

    public static function firebase(string $apiUri, string $apiKey, string $dynamicLinkDomain): Provider
    {
        return new Google\FirebaseProvider(new HttpClient($apiUri), $apiKey, new Domain($dynamicLinkDomain));
    }

    public static function tinyUrl(string $apiUri, string $apiKey): Provider
    {
        return new TinyUrl\TinyUrlProvider(new HttpClient($apiUri), $apiKey);
    }
}
