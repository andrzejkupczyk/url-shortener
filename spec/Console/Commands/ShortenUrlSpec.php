<?php

namespace spec\WebGarden\UrlShortener\Console\Commands;

use PhpSpec\ObjectBehavior;

class ShortenUrlSpec extends ObjectBehavior
{
    public function it_filters_available_providers()
    {
        $this->providers()->shouldBe(['bitly', 'firebase', 'tinyUrl']);
    }
}
