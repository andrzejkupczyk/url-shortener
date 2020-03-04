<?php

namespace spec\WebGarden\UrlShortener\Providers\Google;

use BadMethodCallException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use spec\WebGarden\UrlShortener\Providers\LinkIdentityMatcher;
use WebGarden\UrlShortener\Clients\Http\HttpClient;
use WebGarden\UrlShortener\Model\Entities\Link;
use WebGarden\UrlShortener\Model\ValueObjects\Domain;
use WebGarden\UrlShortener\Model\ValueObjects\StringLiteral;
use WebGarden\UrlShortener\Model\ValueObjects\Url;
use WebGarden\UrlShortener\Providers\Google\FirebaseProvider;

class FirebaseProviderSpec extends ObjectBehavior
{
    use LinkIdentityMatcher;

    protected $link;

    public function __construct()
    {
        $this->link = new Link(
            new StringLiteral(''),
            new Url('https://example.page.link/short'),
            new Url('https://example.page.link/preview')
        );
    }

    function let(HttpClient $client)
    {
        $client->request('shortLinks', Argument::type('array'))->willReturn([
            'shortLink' => 'https://example.page.link/short',
            'previewLink' => 'https://example.page.link/preview',
        ]);

        $this->beConstructedWith($client, '', new Domain('example.page.link'));
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
        $this->useShortSuffix();

        $this->suffixBeingUsed()->shouldBe(FirebaseProvider::SHORT_SUFFIX);
    }

    function it_returns_link_when_url_is_shortened()
    {
        $url = new Url('https://example.page.link/preview');

        $this->shorten($url)->shouldHaveSameIdentity($this->link);
    }

    function it_throws_exception_when_url_is_expanded()
    {
        $url = new Url('https://example.page.link/short');

        $this->shouldThrow(BadMethodCallException::class)->duringExpand($url);
    }
}
