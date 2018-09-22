<?php

namespace WebGarden\UrlShortener\Providers\Google;

use WebGarden\UrlShortener\Model\Entities\Link;
use WebGarden\UrlShortener\Model\Factories\LinkFactory;
use WebGarden\UrlShortener\Model\ValueObjects\Url;
use WebGarden\UrlShortener\Providers\HttpProvider;

/**
 * @deprecated https://developers.googleblog.com/2018/03/transitioning-google-url-shortener.html
 */
class GoogleProvider extends HttpProvider
{
    protected $baseUri = 'https://www.googleapis.com/urlshortener/v1/url';

    protected static function normalizeResponse($stream): array
    {
        $decoded = parent::normalizeResponse($stream);

        return ['id' => 0, 'short_url' => $decoded->id, 'long_url' => $decoded->longUrl];
    }

    public function expand(Url $shortUrl): Link
    {
        $row = $this->request('get', [
            'query' => [
                'shortUrl' => $shortUrl->toNative(),
                'key' => $this->apiKey,
            ],
        ]);

        return LinkFactory::createFromRow($row);
    }

    public function shorten(Url $longUrl): Link
    {
        $row = $this->post([
            'json' => [
                'longUrl' => $longUrl->toNative(),
            ],
            'query' => [
                'key' => $this->apiKey,
            ],
        ]);

        return LinkFactory::createFromRow($row);
    }
}
