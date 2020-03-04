<?php

namespace spec\WebGarden\UrlShortener\Providers\Bitly;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use spec\WebGarden\UrlShortener\Providers\LinkIdentityMatcher;
use WebGarden\UrlShortener\Clients\Http\HttpClient;
use WebGarden\UrlShortener\Model\Entities\Link;
use WebGarden\UrlShortener\Model\ValueObjects\StringLiteral;
use WebGarden\UrlShortener\Model\ValueObjects\Url;
use WebGarden\UrlShortener\Providers\Bitly\BitlyProvider;

class BitlyProviderSpec extends ObjectBehavior
{
    use LinkIdentityMatcher;

    protected $link;

    function __construct()
    {
        $this->link = new Link(
            new StringLiteral('bit.ly/2Dkm8SJ'),
            new Url('http://bit.ly/2Dkm8SJ'),
            new Url('https://github.com/andrzejkupczyk/url-shortener')
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

    function it_returns_link_when_url_is_expanded()
    {
        $url = new Url('http://bit.ly/2Dkm8SJ');

        $this->expand($url)->shouldHaveSameIdentity($this->link);
    }

    function it_returns_link_when_url_is_shortened()
    {
        $url = new Url('https://github.com/andrzejkupczyk/url-shortener');

        $this->shorten($url)->shouldHaveSameIdentity($this->link);
    }
}
