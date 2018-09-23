<?php

namespace WebGarden\UrlShortener\Providers\TinyUrl;

use WebGarden\UrlShortener\Model\Entities\Link;
use WebGarden\UrlShortener\Model\Factories\LinkFactory;
use WebGarden\UrlShortener\Model\ValueObjects\Url;
use WebGarden\UrlShortener\Providers\Http\HttpProvider;

class TinyUrlProvider extends HttpProvider
{
    protected $baseUri = 'http://tiny-url.info/api/v1/';

    /** @var string Shorting URL service provider. */
    protected $providerUrl = 'tinyurl_com';

    protected static function normalizeResponse($stream): array
    {
        $decoded = parent::normalizeResponse($stream);

        return [
            'id' => '',
            'short_url' => $decoded->shorturl,
            'long_url' => $decoded->longurl,
        ];
    }

    public function expand(Url $shortUrl): Link
    {
        throw new \BadMethodCallException(
            'The Tiny URL does not provide an API which allows to expand shortened URLs.'
        );
    }

    /**
     * Set shorting URL service provider.
     *
     * @see http://tiny-url.info/open_api.html#provider_list
     * @param  string $providerUrl
     * @return self
     */
    public function providerUrl(string $providerUrl)
    {
        $this->providerUrl = $providerUrl;

        return $this;
    }

    public function shorten(Url $longUrl): Link
    {
        $options = [
            'form_params' => [
                'format' => 'json',
                'apikey' => $this->apiKey,
                'provider' => $this->providerUrl,
                'url' => $longUrl->toNative(),
            ],
        ];

        return LinkFactory::createFromRow($this->request('create', $options));
    }
}
