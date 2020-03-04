<?php

namespace spec\WebGarden\UrlShortener\Model\ValueObjects;

use InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use WebGarden\UrlShortener\Model\ValueObjects\Domain;

class DomainSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('andrzejkupczyk.pl');

        $this->shouldHaveType(Domain::class);
    }

    function it_validates_itself()
    {
        $this->beConstructedWith('http://andrzejkupczyk.pl');

        $this->shouldThrow(InvalidArgumentException::class)->duringInstantiation();
    }
}
