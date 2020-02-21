<?php

namespace WebGarden\UrlShortener\Clients\Http\Middleware;

use Psr\Http\Message\RequestInterface;

class AddOAuthToken
{
    /** @var string */
    protected $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function __invoke(callable $handler): callable
    {
        return function (RequestInterface $request, array $options) use ($handler) {
            $request = $request->withHeader('Authorization', "Bearer {$this->token}");

            return $handler($request, $options);
        };
    }
}
