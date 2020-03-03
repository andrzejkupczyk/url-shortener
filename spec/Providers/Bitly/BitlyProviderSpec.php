<?php

namespace spec\WebGarden\UrlShortener\Providers\Bitly;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use spec\WebGarden\UrlShortener\Providers\LinkIdentityMatcher;
use WebGarden\Model\ValueObject\StringLiteral\StringLiteral;
use WebGarden\Model\ValueObject\StringLiteral\StringLiteral as Id;
use WebGarden\UrlShortener\Clients\Http\HttpClient;
use WebGarden\UrlShortener\Model\Entities\Link;
use WebGarden\UrlShortener\Model\ValueObjects\Url;
use WebGarden\UrlShortener\Providers\Bitly\BitlyProvider;

class BitlyProviderSpec extends ObjectBehavior
{
    use LinkIdentityMatcher;

    protected $link;

    function __construct()
    {
        $this->link = new Link(
            Id::fromNative('bit.ly/2Dkm8SJ'),
            Url::fromNative('http://bit.ly/2Dkm8SJ'),
            Url::fromNative('https://github.com/andrzejkupczyk/url-shortener')
        );
    }

    function let(HttpClient $client)
    {
        $client->request(Argument::type('string'), Argument::type('array'))->willReturn([
            'id' => 'bit.ly/2Dkm8SJ',
            'link' => 'http://bit.ly/2Dkm8SJ',
            'long_url' => 'https://github.com/andrzejkupczyk/url-shortener',
        ]);

        $this->beConstructedWith($client);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(BitlyProvider::class);
    }

    function it_returns_link_when_url_is_expanded(Url $url)
    {
        $url->path()->willReturn(StringLiteral::fromNative('2Dkm8SJ'));

        $this->expand($url)->shouldHaveSameIdentity($this->link);
    }

    function it_returns_link_when_url_is_shortened(Url $url)
    {
        $this->shorten($url)->shouldHaveSameIdentity($this->link);
    }
}
