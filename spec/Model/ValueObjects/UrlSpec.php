<?php

namespace spec\WebGarden\UrlShortener\Model\Domain\ValueObjects;

use PhpSpec\ObjectBehavior;
use WebGarden\Model\Assert\AssertionException;
use WebGarden\UrlShortener\Model\ValueObjects\Url;

class UrlSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('https://github.com/andrzejkupczyk');

        $this->shouldHaveType(Url::class);
    }

    function it_validates_itself()
    {
        $this->beConstructedWith('an-invalid-url');

        $this->shouldThrow(AssertionException::class)->duringInstantiation();
    }
}
