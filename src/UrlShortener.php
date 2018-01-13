<?php

namespace WebGarden\UrlShortener;

use Illuminate\Database\Query\Builder;
use WebGarden\UrlShortener\Model\Entities\Link;
use WebGarden\UrlShortener\Model\ValueObjects\Url;
use WebGarden\UrlShortener\Providers\Database\EloquentProvider;
use WebGarden\UrlShortener\Providers\Google\GoogleProvider;
use WebGarden\UrlShortener\Providers\Provider;
use WebGarden\UrlShortener\Providers\TinyUrl\TinyUrlProvider;

/**
 * @method Link expand(Url $shortUrl)
 * @method Link shorten(Url $longUrl)
 */
class UrlShortener
{
    /** @var Provider */
    private $provider;

    public static function eloquent(Url $baseUrl, Builder $query)
    {
        return new static(new EloquentProvider($baseUrl, $query));
    }

    public static function google(string $apiKey)
    {
        return new static(new GoogleProvider($apiKey));
    }

    public static function tinyUrl(string $apiKey)
    {
        return new static(new TinyUrlProvider($apiKey));
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
