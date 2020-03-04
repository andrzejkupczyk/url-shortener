<?php

namespace spec\WebGarden\UrlShortener\Model\Entities;

use PhpSpec\ObjectBehavior;
use WebGarden\Model\Entity\Entity;
use WebGarden\UrlShortener\Model\Entities\Link;
use WebGarden\UrlShortener\Model\ValueObjects\StringLiteral;
use WebGarden\UrlShortener\Model\ValueObjects\Url;

class LinkSpec extends ObjectBehavior
{
    function let()
    {
        $id = new StringLiteral('1');
        $url = new Url('https://github.com/andrzejkupczyk/url-shortener');

        $this->beConstructedWith($id, $url, $url);
    }

    function it_is_initializable()
    {
        $this->shouldImplement(Entity::class);
        $this->shouldHaveType(Link::class);
    }
}
