<?php

namespace spec\WebGarden\UrlShortener\Model\Factories;

use PhpSpec\ObjectBehavior;
use WebGarden\UrlShortener\Model\ValueObjects\Shortcode;

class ShortcodeFactorySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('createUsingSnowflake');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Shortcode::class);
    }

    function it_generates_shortcode()
    {
        $this->__toString()->shouldBeNumeric();
    }
}
