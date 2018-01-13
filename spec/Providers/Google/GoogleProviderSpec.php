<?php

namespace spec\WebGarden\UrlShortener\Providers\Google;

use GuzzleHttp\ClientInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\ResponseInterface;
use WebGarden\Model\ValueObject\Number\Natural as Id;
use WebGarden\UrlShortener\Model\Entities\Link;
use WebGarden\UrlShortener\Model\ValueObjects\Url;
use WebGarden\UrlShortener\Providers\Google\GoogleProvider;

class GoogleProviderSpec extends ObjectBehavior
{
    protected $link;

    public function __construct()
    {
        $this->link = new Link(
            Id::fromNative(0),
            Url::fromNative('http://goo.gl/pwg8ss'),
            Url::fromNative('https://github.com/andrzejkupczyk')
        );
    }

    function let(ClientInterface $client, ResponseInterface $response, Url $url)
    {
        $url->toNative()->willReturn(Argument::type('string'));

        $response->getBody()->willReturn('{"id":"http://goo.gl/pwg8ss","longUrl":"https://github.com/andrzejkupczyk"}');
        $client->request(
            Argument::type('string'), 'https://www.googleapis.com/urlshortener/v1/url', Argument::type('array')
        )->willReturn($response);

        $this->beConstructedWith(Argument::type('string'), $client);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(GoogleProvider::class);
    }

    function it_returns_link_when_url_is_shortened(Url $url)
    {
        $this->shorten($url)->shouldHaveSameIdentity($this->link);
    }

    function it_returns_link_when_url_is_expanded(Url $url)
    {
        $this->expand($url)->shouldHaveSameIdentity($this->link);
    }

    public function getMatchers(): array
    {
        return [
            'haveSameIdentity' => function ($link1, $link2) {
                return $link1->sameIdentityAs($link2);
            },
        ];
    }
}
