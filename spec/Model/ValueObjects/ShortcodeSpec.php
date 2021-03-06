<?php

namespace spec\WebGarden\UrlShortener\Model\ValueObjects;

use InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use WebGarden\UrlShortener\Model\ValueObjects\Shortcode;

class ShortcodeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(Argument::type('string'));

        $this->shouldHaveType(Shortcode::class);
    }

    function it_should_throw_an_error_when_assertion_fails()
    {
        $this->beConstructedWith('!@#$%^&*()_+');

        $this->shouldThrow(InvalidArgumentException::class)->duringInstantiation();
    }
}
