<?php

namespace spec\WebGarden\UrlShortener\Providers\Google;

use GuzzleHttp\Client;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\ResponseInterface;
use WebGarden\Model\ValueObject\StringLiteral\StringLiteral as Id;
use WebGarden\UrlShortener\Model\Entities\Link;
use WebGarden\UrlShortener\Model\ValueObjects\Domain;
use WebGarden\UrlShortener\Model\ValueObjects\Url;
use WebGarden\UrlShortener\Providers\Google\FirebaseProvider;

class FirebaseProviderSpec extends ObjectBehavior
{
    protected $link;

    public function __construct()
    {
        $this->link = new Link(
            Id::fromNative(''),
            Url::fromNative('https://example.page.link/short'),
            Url::fromNative('https://example.page.link/preview')
        );
    }

    function let(Client $client, ResponseInterface $response, Domain $domain)
    {
        $response->getBody()->willReturn(
            '{"shortLink":"https://example.page.link/short","previewLink":"https://example.page.link/preview"}'
        );
        $client->post('shortLinks', Argument::type('array'))->willReturn($response);

        $this->beConstructedWith(Argument::type('string'), $domain, $client);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FirebaseProvider::class);
    }

    function it_uses_unguessable_suffix_as_default()
    {
        $this->suffixBeingUsed()->shouldBe(FirebaseProvider::UNGUESSABLE_SUFFIX);
    }

    function it_specifies_that_suffix_should_be_short()
    {
        $this->usingShortSuffix();

        $this->suffixBeingUsed()->shouldBe(FirebaseProvider::SHORT_SUFFIX);
    }

    function it_returns_link_when_url_is_shortened(Url $url)
    {
        $this->shorten($url)->shouldHaveSameIdentity($this->link);
    }

    function it_throws_exception_when_url_is_expanded(Url $url)
    {
        $this->shouldThrow(\BadMethodCallException::class)->duringExpand($url);
    }

    public function getMatchers(): array
    {
        return [
            'haveSameIdentity' => function (Link $link1, Link $link2) {
                return $link1->sameIdentityAs($link2);
            },
        ];
    }
}
