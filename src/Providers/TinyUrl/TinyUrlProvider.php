<?php

namespace WebGarden\UrlShortener\Providers\TinyUrl;

use WebGarden\UrlShortener\Model\Entities\Link;
use WebGarden\UrlShortener\Model\Factories\LinkFactory;
use WebGarden\UrlShortener\Model\ValueObjects\Url;
use WebGarden\UrlShortener\Providers\HttpProvider;

class TinyUrlProvider extends HttpProvider
{
    /** @see http://tiny-url.info/open_api.html#provider_list */
    const PROVIDER = 'tinyurl_com';

    /** @var string */
    protected $baseUri = 'http://tiny-url.info/api/v1/create';

    static protected function normalizeResponse($stream): array
    {
        $decoded = parent::normalizeResponse($stream);

        return ['id' => 0, 'short_url' => $decoded->shorturl, 'long_url' => $decoded->longurl];
    }

    public function expand(Url $shortUrl): Link
    {
        throw new \BadMethodCallException(
            'The Tiny URL does not provide an API which allows to expand shortened URLs.'
        );
    }

    public function shorten(Url $longUrl): Link
    {
        $row = $this->request('post', [
            'form_params' => [
                'format' => 'json',
                'apikey' => $this->apiKey,
                'provider' => static::PROVIDER,
                'url' => $longUrl->toNative(),
            ],
        ]);

        return LinkFactory::createFromRow($row);
    }
}
