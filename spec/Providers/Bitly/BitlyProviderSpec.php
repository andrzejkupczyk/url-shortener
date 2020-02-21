<?php

namespace spec\WebGarden\UrlShortener\Providers\Bitly;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\ResponseInterface;
use spec\WebGarden\UrlShortener\Providers\LinkIdentityMatcher;
use WebGarden\Model\ValueObject\StringLiteral\StringLiteral;
use WebGarden\Model\ValueObject\StringLiteral\StringLiteral as Id;
use WebGarden\UrlShortener\Model\Entities\Link;
use WebGarden\UrlShortener\Model\ValueObjects\Domain;
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

    function let(Client $client, ResponseInterface $response, HandlerStack $stack)
    {
        $response->getBody()->willReturn('{"long_url":"https://github.com/andrzejkupczyk/url-shortener","link":"http://bit.ly/2Dkm8SJ","id":"bit.ly/2Dkm8SJ"}');
        $client->getConfig('handler')->willReturn($stack);

        $this->beConstructedWith(Argument::type('string'), Domain::fromNative('bit.ly'), $client);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(BitlyProvider::class);
    }

    function it_returns_link_when_url_is_expanded($client, $response, Url $url)
    {
        $url->path()->willReturn(StringLiteral::fromNative('2Dkm8SJ'));
        $client->post('expand', Argument::type('array'))->willReturn($response);

        $this->expand($url)->shouldHaveSameIdentity($this->link);
    }

    function it_returns_link_when_url_is_shortened($client, $response, Url $url)
    {
        $client->post('bitlinks', Argument::type('array'))->willReturn($response);

        $this->shorten($url)->shouldHaveSameIdentity($this->link);
    }
}
