<?php

namespace WebGarden\UrlShortener\Providers;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\StreamInterface;

abstract class HttpProvider implements Provider
{
    /** @var string */
    protected $apiKey;

    /** @var string */
    protected $baseUri;

    /** @var Client */
    protected $client;

    /**
     * @param  StreamInterface $stream
     *
     * @return object
     */
    static protected function normalizeResponse($stream)
    {
        return \GuzzleHttp\json_decode($stream);
    }

    public function __construct(string $apiKey, ClientInterface $client = null)
    {
        $this->apiKey = $apiKey;
        $this->client = $client ?: new Client(['timeout' => 2]);
    }

    /**
     * Get normalized response.
     *
     * @param  string $method
     * @param  array  $options
     *
     * @return mixed
     */
    protected function request(string $method, array $options = [])
    {
        $response = $this->client->request($method, $this->baseUri ?? '', $options);

        return static::normalizeResponse($response->getBody());
    }
}
