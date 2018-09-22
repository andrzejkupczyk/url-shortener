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

    /** @var int */
    protected $connectionTimeout = 10;

    /** @var Client */
    protected $client;

    /**
     * @param  StreamInterface $stream
     * @return object
     */
    protected static function normalizeResponse($stream)
    {
        return \GuzzleHttp\json_decode($stream);
    }

    public function __construct(string $apiKey, ClientInterface $client = null)
    {
        $this->apiKey = $apiKey;
        $this->client = $client ?: new Client([
            'timeout' => $this->connectionTimeout,
        ]);
    }

    /**
     * Send a POST request and get normalized response.
     *
     * @param  array $options
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function post(array $options = [])
    {
        return $this->request(__METHOD__, $options);
    }

    /**
     * Send a request and get normalized response.
     *
     * @param  string $method
     * @param  array $options
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function request(string $method, array $options = [])
    {
        $response = $this->client->request($method, $this->baseUri ?? '', $options);

        return static::normalizeResponse($response->getBody());
    }
}
