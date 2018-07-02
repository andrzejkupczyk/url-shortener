<?php

namespace spec\WebGarden\UrlShortener\Model\ValueObjects;

use PhpSpec\ObjectBehavior;
use WebGarden\Model\Assert\AssertionException;
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

        $this->shouldThrow(AssertionException::class)->duringInstantiation();
    }
}
