<?php

declare(strict_types=1);

namespace WebGarden\UrlShortener\Clients\Http\Middleware;

use Closure;
use Psr\Http\Message\RequestInterface;

class AddOAuthToken
{
    protected string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * @psalm-return \Closure(RequestInterface, array):mixed
     */
    public function __invoke(Closure $handler): Closure
    {
        return function (RequestInterface $request, array $options) use ($handler) {
            $request = $request->withHeader('Authorization', "Bearer {$this->token}");

            return $handler($request, $options);
        };
    }
}
