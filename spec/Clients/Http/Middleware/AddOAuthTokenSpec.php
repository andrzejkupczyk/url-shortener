<?php

namespace spec\WebGarden\UrlShortener\Clients\Http\Middleware;

use PhpSpec\ObjectBehavior;
use Psr\Http\Message\RequestInterface;
use WebGarden\UrlShortener\Clients\Http\Middleware\AddOAuthToken;

class AddOAuthTokenSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('foobar');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AddOAuthToken::class);
    }

    function it_adds_authorization_header_to_the_request(RequestInterface $request)
    {
        $handler = $this(function() {});

        $handler($request, []);

        $request->withHeader('Authorization', 'Bearer foobar')->shouldHaveBeenCalledOnce();
    }
}
