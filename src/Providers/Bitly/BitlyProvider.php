<?php

namespace WebGarden\UrlShortener\Providers\Bitly;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;
use WebGarden\UrlShortener\Model\Entities\Link;
use WebGarden\UrlShortener\Model\Factories\LinkFactory;
use WebGarden\UrlShortener\Model\ValueObjects\Domain;
use WebGarden\UrlShortener\Model\ValueObjects\Url;
use WebGarden\UrlShortener\Providers\Http\HttpProvider;
use WebGarden\UrlShortener\Providers\Http\Middleware\AddOAuthToken;

class BitlyProvider extends HttpProvider
{
    protected $baseUri = 'https://api-ssl.bitly.com/v4/';

    /** @var Domain */
    protected $domain;

    protected static function normalizeResponse($stream): array
    {
        $decoded = parent::normalizeResponse($stream);

        return [
            'id' => $decoded->id,
            'short_url' => $decoded->link,
            'long_url' => $decoded->long_url,
        ];
    }

    public function __construct(string $apiKey, Domain $domain, ClientInterface $client = null)
    {
        parent::__construct($apiKey, $client);
        $this->pushMiddleware(new AddOAuthToken($this->apiKey));

        $this->domain = $domain;
    }

    public function expand(Url $shortUrl): Link
    {
        $row = $this->request('expand', [
            RequestOptions::JSON => [
                'bitlink_id' => $this->domain . $shortUrl->path(),
            ],
        ]);

        return LinkFactory::createFromRow($row);
    }

    public function shorten(Url $longUrl): Link
    {
        $row = $this->request('bitlinks', [
            RequestOptions::JSON => [
                'domain' => $this->domain->toNative(),
                'long_url' => $longUrl->toNative(),
            ],
        ]);

        return LinkFactory::createFromRow($row);
    }
}