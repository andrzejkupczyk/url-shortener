<?php

declare(strict_types=1);

namespace WebGarden\UrlShortener\Providers\TinyUrl;

use BadMethodCallException;
use GuzzleHttp\RequestOptions;
use WebGarden\UrlShortener\Clients\Http\HttpClient;
use WebGarden\UrlShortener\Model\Entities\Link;
use WebGarden\UrlShortener\Model\Factories\LinkFactory;
use WebGarden\UrlShortener\Model\ValueObjects\Url;
use WebGarden\UrlShortener\Providers\Provider;

class TinyUrlProvider implements Provider
{
    protected HttpClient $client;

    protected string $apiKey;

    /** @var string URL shortening service provider */
    protected string $providerUrl = 'tinyurl_com';

    public function __construct(HttpClient $client, string $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    public function expand(Url $shortUrl): Link
    {
        throw new BadMethodCallException(
            'The Tiny URL does not provide an API which allows to expand shortened URLs.'
        );
    }

    /**
     * Set shorting URL service provider.
     *
     * @see http://tiny-url.info/open_api.html#provider_list
     */
    public function changeProviderUrl(string $providerUrl): void
    {
        $this->providerUrl = $providerUrl;
    }

    public function shorten(Url $longUrl): Link
    {
        $options = [
            RequestOptions::FORM_PARAMS => [
                'format' => 'json',
                'apikey' => $this->apiKey,
                'provider' => $this->providerUrl,
                'url' => (string) $longUrl,
            ],
        ];

        $response = $this->client->request('create', $options);

        return LinkFactory::create('', $response['shorturl'], $response['longurl']);
    }
}
