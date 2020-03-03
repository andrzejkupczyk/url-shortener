<?php

namespace WebGarden\UrlShortener;

use WebGarden\UrlShortener\Model\Entities\Link;
use WebGarden\UrlShortener\Model\ValueObjects\Url;
use WebGarden\UrlShortener\Providers\Factory as ProviderFactory;
use WebGarden\UrlShortener\Providers\Provider;

/**
 * @method static UrlShortener bitly(string $apiUri, string $apiKey, string $domain)
 * @method static UrlShortener firebase(string $apiUri, string $apiKey, string $dynamicLinkDomain)
 * @method static UrlShortener tinyUrl(string $apiUri, string $apiKey)
 */
final class UrlShortener implements Provider
{
    /** @var Provider */
    private $provider;

    public static function __callStatic($name, $arguments)
    {
        $provider = ProviderFactory::$name(...$arguments);

        return new static($provider);
    }

    public function __construct(Provider $provider)
    {
        $this->provider = $provider;
    }

    public function expand(Url $shortUrl): Link
    {
        return $this->provider->expand($shortUrl);
    }

    public function shorten(Url $longUrl): Link
    {
        return $this->provider->shorten($longUrl);
    }

    public function provider(): Provider
    {
        return $this->provider;
    }
}
