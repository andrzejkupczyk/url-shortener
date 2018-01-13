<?php

namespace WebGarden\UrlShortener\Providers\Google;

use WebGarden\UrlShortener\Model\Entities\Link;
use WebGarden\UrlShortener\Model\Factories\LinkFactory;
use WebGarden\UrlShortener\Model\ValueObjects\Url;
use WebGarden\UrlShortener\Providers\HttpProvider;

class GoogleProvider extends HttpProvider
{
    /** @var string */
    protected $baseUri = 'https://www.googleapis.com/urlshortener/v1/url';

    static protected function normalizeResponse($stream): array
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
        $row = $this->request('post', [
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
