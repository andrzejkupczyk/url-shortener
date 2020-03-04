<?php

declare(strict_types=1);

namespace WebGarden\UrlShortener\Clients\Http;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\RequestOptions;

class HttpClient
{
    public const DEFAULT_OPTIONS = [
        RequestOptions::TIMEOUT => 10,
    ];

    /** @var \GuzzleHttp\ClientInterface */
    protected $client;

    public function __construct(string $apiUri, array $options = self::DEFAULT_OPTIONS)
    {
        $this->client = new Client(array_merge($options, ['base_uri' => $apiUri]));
    }

    /**
     * Send request and get normalized response.
     */
    public function request(string $path, array $options = []): array
    {
        $response = $this->client->post($path, $options)->getBody();

        return \GuzzleHttp\json_decode($response, true);
    }

    /**
     * Push a middleware to the top of the handler stack.
     */
    public function pushMiddleware(callable $middleware): void
    {
        $this->handler()->push($middleware);
    }

    /**
     * Return handler utilized by the client.
     */
    protected function handler(): HandlerStack
    {
        return $this->client->getConfig('handler');
    }
}
