<?php

namespace WebGarden\UrlShortener\Providers\Bitly;

use GuzzleHttp\RequestOptions;
use WebGarden\UrlShortener\Clients\Http\HttpClient;
use WebGarden\UrlShortener\Model\Entities\Link;
use WebGarden\UrlShortener\Model\Factories\LinkFactory;
use WebGarden\UrlShortener\Model\ValueObjects\Domain;
use WebGarden\UrlShortener\Model\ValueObjects\Url;
use WebGarden\UrlShortener\Providers\Provider;

class BitlyProvider implements Provider
{
    /** @var string */
    public const DEFAULT_DOMAIN = 'bit.ly';

    /** @var HttpClient */
    protected $client;

    /** @var Domain */
    protected $domain;

    public function __construct(HttpClient $client, ?Domain $domain = null)
    {
        $this->client = $client;
        $this->domain = $domain ?: Domain::fromNative(self::DEFAULT_DOMAIN);
    }

    public function expand(Url $shortUrl): Link
    {
        $options = [
            RequestOptions::JSON => [
                'bitlink_id' => $this->domain . $shortUrl->path(),
            ],
        ];

        $response = $this->client->request('expand', $options);

        return $this->createLink($response);
    }

    public function shorten(Url $longUrl): Link
    {
        $options = [
            RequestOptions::JSON => [
                'domain' => $this->domain->toNative(),
                'long_url' => $longUrl->toNative(),
            ],
        ];

        $response = $this->client->request('bitlinks', $options);

        return $this->createLink($response);
    }

    private function createLink(array $response): Link
    {
        return LinkFactory::createFromRow([
            'id' => $response['id'],
            'short_url' => $response['link'],
            'long_url' => $response['long_url'],
        ]);
    }
}
