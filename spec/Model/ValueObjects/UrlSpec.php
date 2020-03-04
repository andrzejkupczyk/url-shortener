<?php

namespace spec\WebGarden\UrlShortener\Model\ValueObjects;

use InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use WebGarden\UrlShortener\Model\ValueObjects\StringLiteral;
use WebGarden\UrlShortener\Model\ValueObjects\Url;

class UrlSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('https://github.com/andrzejkupczyk/url-shortener');

        $this->shouldHaveType(Url::class);
    }

    function it_validates_itself()
    {
        $this->beConstructedWith('an-invalid-url');

        $this->shouldThrow(InvalidArgumentException::class)->duringInstantiation();
    }

    function it_retrieves_a_path_component()
    {
        $this->beConstructedWith('https://github.com/andrzejkupczyk/url-shortener');
        $path = new StringLiteral('andrzejkupczyk');

        $this->path()->sameValueAs($path);
    }
}
