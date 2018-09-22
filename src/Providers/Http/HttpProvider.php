<?php

namespace WebGarden\UrlShortener\Providers\Http;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\StreamInterface;
use WebGarden\UrlShortener\Providers\Provider;

abstract class HttpProvider implements Provider
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
            'base_uri' => $this->baseUri,
            'handler' => HandlerStack::create(),
            'timeout' => $this->connectionTimeout,
        ]);
    }

    /**
     * Send request and get normalized response.
     *
     * @param  string $uri
     * @param  array $options
     * @return object
     */
    protected function request(string $uri = '', array $options = [])
    {
        return static::normalizeResponse($this->client->post($uri, $options)->getBody());
    }

    /**
     * Push a middleware to the top of the handler stack.
     *
     * @param  callable $middleware
     * @param  string $name
     */
    protected function pushMiddleware(callable $middleware, string $name = '')
    {
        $this->handler()->push($middleware, $name);
    }

    /**
     * Return handler utilized by the client.
     *
     * @return \GuzzleHttp\HandlerStack
     */
    private function handler(): HandlerStack
    {
        return $this->client->getConfig('handler');
    }
}
