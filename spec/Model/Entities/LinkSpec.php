<?php

namespace spec\WebGarden\UrlShortener\Model\Entities;

use PhpSpec\ObjectBehavior;
use WebGarden\Model\Entity\Entity;
use WebGarden\Model\ValueObject\StringLiteral\StringLiteral as Id;
use WebGarden\UrlShortener\Model\Entities\Link;
use WebGarden\UrlShortener\Model\ValueObjects\Url;

class LinkSpec extends ObjectBehavior
{
    function let(Id $id, Url $url)
    {
        $this->beConstructedWith($id, $url, $url);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Link::class);
        $this->shouldHaveType(Entity::class);
    }

    function it_should_be_identified_by_a_natural_number()
    {
        $this->id()->shouldBeAnInstanceOf(Id::class);
    }
}
