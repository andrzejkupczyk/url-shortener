<?php

namespace spec\WebGarden\UrlShortener;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use WebGarden\UrlShortener\Model\ValueObjects\Domain;
use WebGarden\UrlShortener\Providers\Google\FirebaseProvider;
use WebGarden\UrlShortener\Providers\Google\GoogleProvider;
use WebGarden\UrlShortener\Providers\Provider;
use WebGarden\UrlShortener\UrlShortener;

class UrlShortenerSpec extends ObjectBehavior
{
    function it_is_initializable(Provider $provider)
    {
        $this->beConstructedWith($provider);

        $this->shouldHaveType(UrlShortener::class);
    }

    function it_is_initializable_statically_using_the_google_provider()
    {
        $this->beConstructedWith(new GoogleProvider(Argument::type('string')));

        $subject = UrlShortener::google(Argument::type('string'));

        $this->provider()->shouldBeAnInstanceOf(get_class($subject->provider()));
    }

    function it_is_initializable_statically_using_the_firebase_provider()
    {
        $this->beConstructedWith(
            new FirebaseProvider(Argument::type('string'), new Domain('example.page.link'))
        );

        $subject = UrlShortener::firebase(Argument::type('string'), 'example.page.link');

        $this->provider()->shouldBeAnInstanceOf(get_class($subject->provider()));
    }
}
