<?php

namespace spec\WebGarden\UrlShortener\Console\Commands;

use PhpSpec\ObjectBehavior;

class ExpandUrlSpec extends ObjectBehavior
{
    public function it_filters_available_providers()
    {
        $this->providers()->shouldBe(['bitly']);
    }
}
