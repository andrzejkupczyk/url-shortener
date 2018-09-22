<?php

namespace WebGarden\UrlShortener;

use Illuminate\Database\Query\Builder;
use WebGarden\UrlShortener\Model\Entities\Link;
use WebGarden\UrlShortener\Model\ValueObjects\Domain;
use WebGarden\UrlShortener\Model\ValueObjects\Url;
use WebGarden\UrlShortener\Providers\Factory as ProviderFactory;
use WebGarden\UrlShortener\Providers\Provider;

/**
 * @method static UrlShortener eloquent(Url $baseUrl, Builder $query)
 * @method static UrlShortener firebase(string $apiKey, Domain $dynamicLinkDomain)
 * @method static UrlShortener google(string $apiKey)
 * @method static UrlShortener tinyUrl(string $apiKey)
 * @method Link expand(Url $shortUrl)
 * @method Link shorten(Url $longUrl)
 */
class UrlShortener
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

    public function provider(): Provider
    {
        return $this->provider;
    }

    public function __call(string $name, array $arguments)
    {
        return call_user_func_array([$this->provider, $name], $arguments);
    }
}
