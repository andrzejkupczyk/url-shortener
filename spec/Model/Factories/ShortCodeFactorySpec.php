<?php

namespace spec\WebGarden\UrlShortener\Model\Factories;

use PhpSpec\ObjectBehavior;
use WebGarden\Model\ValueObject\Number\Natural;
use WebGarden\UrlShortener\Model\ValueObjects\ShortCode;

class ShortCodeFactorySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('createFromId', [Natural::fromNative(123456)]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ShortCode::class);
    }

    function it_generates_short_code()
    {
        $this->toNative()->shouldBe('yIw');
    }
}
