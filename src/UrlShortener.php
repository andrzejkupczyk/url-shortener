<?php

namespace WebGarden\UrlShortener;

use Illuminate\Database\Query\Builder;
use WebGarden\UrlShortener\Model\Entities\Link;
use WebGarden\UrlShortener\Model\ValueObjects\Url;
use WebGarden\UrlShortener\Providers\Provider;

/**
 * @method static UrlShortener eloquent(Url $baseUrl, Builder $query)
 * @method static UrlShortener google(string $apiKey)
 * @method static UrlShortener tinyUrl(string $apiKey)
 * @method Link expand(Url $shortUrl)
 * @method Link shorten(Url $longUrl)
 */
class UrlShortener
{
    /** @var array */
    protected static $providers = [
        'eloquent' => Providers\Database\EloquentProvider::class,
        'google' => Providers\Google\GoogleProvider::class,
        'tinyUrl' => Providers\TinyUrl\TinyUrlProvider::class,
    ];

    /** @var Provider */
    private $provider;

    public static function __callStatic($name, $arguments)
    {
        if (empty(static::$providers[$name])) {
            throw new \BadMethodCallException("The $name method does not exist.");
        }

        $provider = new static::$providers[$name](...$arguments);

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
