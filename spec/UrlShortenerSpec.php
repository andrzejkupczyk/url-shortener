<?php

namespace spec\WebGarden\UrlShortener;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use WebGarden\UrlShortener\Providers\Google\GoogleProvider;
use WebGarden\UrlShortener\Providers\Provider;
use WebGarden\UrlShortener\UrlShortener;

class UrlShortenerSpec extends ObjectBehavior
{
    function it_is_initializable(Provider $provider)
    {
        $this->beConstructedWith($provider);

        $this->shouldHaveType(UrlShortener::class);
    }

    function it_is_initializable_statically()
    {
        $this->beConstructedThrough('google', [Argument::type('string')]);

        $this->provider()->shouldBeAnInstanceOf(GoogleProvider::class);
    }
}
