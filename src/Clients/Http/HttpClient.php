<?php

namespace WebGarden\UrlShortener\Clients\Http;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\HandlerStack;

abstract class HttpClient
{
    /** @var string */
    protected $apiKey;

    /** @var string */
    protected $baseUri;

    /** @var \GuzzleHttp\ClientInterface */
    protected $client;

    /** @var int */
    protected $connectionTimeout = 10;

    /**
     * @param \Psr\Http\Message\StreamInterface|string $stream
     */
    protected static function normalizeResponse($stream): array
    {
        return \GuzzleHttp\json_decode($stream, true);
    }

    public function __construct(string $apiKey, ?ClientInterface $client = null)
    {
        $this->apiKey = $apiKey;
        $this->client = $client ?: new Client([
            'base_uri' => $this->baseUri,
            'handler' => HandlerStack::create(),
            'timeout' => $this->connectionTimeout,
        ]);
    }

    /**
     * Send request and get normalized response.
     */
    protected function request(string $uri = '', array $options = [])
    {
        return static::normalizeResponse($this->client->post($uri, $options)->getBody());
    }

    /**
     * Push a middleware to the top of the handler stack.
     */
    protected function pushMiddleware(callable $middleware, string $name = ''): void
    {
        $this->handler()->push($middleware, $name);
    }

    /**
     * Return handler utilized by the client.
     */
    private function handler(): HandlerStack
    {
        return $this->client->getConfig('handler');
    }
}
