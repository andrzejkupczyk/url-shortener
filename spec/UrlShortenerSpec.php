<?php

namespace spec\WebGarden\UrlShortener;

use PhpSpec\ObjectBehavior;
use WebGarden\UrlShortener\Clients\Http\HttpClient;
use WebGarden\UrlShortener\Model\ValueObjects\Domain;
use WebGarden\UrlShortener\Providers\Bitly\BitlyProvider;
use WebGarden\UrlShortener\Providers\Google\FirebaseProvider;
use WebGarden\UrlShortener\Providers\Provider;
use WebGarden\UrlShortener\Providers\TinyUrl\TinyUrlProvider;
use WebGarden\UrlShortener\UrlShortener;

class UrlShortenerSpec extends ObjectBehavior
{
    function it_is_initializable(Provider $provider)
    {
        $this->beConstructedWith($provider);

        $this->shouldHaveType(UrlShortener::class);
    }

    function it_is_initializable_statically_using_the_bitly_provider()
    {
        $this->beConstructedWith(new BitlyProvider(new HttpClient(''), new Domain('bit.ly')));

        $subject = UrlShortener::bitly('', '', 'bit.ly');

        $this->provider()->shouldBeAnInstanceOf(get_class($subject->provider()));
    }

    function it_is_initializable_statically_using_the_firebase_provider()
    {
        $this->beConstructedWith(new FirebaseProvider(new HttpClient(''), '', new Domain('example.page.link')));

        $subject = UrlShortener::firebase('', '', 'example.page.link');

        $this->provider()->shouldBeAnInstanceOf(get_class($subject->provider()));
    }

    function it_is_initializable_statically_using_the_tinyurl_provider()
    {
        $this->beConstructedWith(new TinyUrlProvider(new HttpClient(''), ''));

        $subject = UrlShortener::tinyUrl('', '');

        $this->provider()->shouldBeAnInstanceOf(get_class($subject->provider()));
    }
}
