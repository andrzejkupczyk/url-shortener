<?php

namespace spec\WebGarden\UrlShortener\Providers\TinyUrl;

use BadMethodCallException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use WebGarden\UrlShortener\Clients\Http\HttpClient;
use WebGarden\UrlShortener\Model\ValueObjects\Url;
use WebGarden\UrlShortener\Providers\TinyUrl\TinyUrlProvider;

class TinyUrlProviderSpec extends ObjectBehavior
{
    function let(HttpClient $client)
    {
        $client->request(Argument::any(), Argument::any())->willReturn([
            'shorturl' => 'http://tinyurl.com/uahhqrv',
            'longurl' => 'https://github.com/andrzejkupczyk/url-shortener',
        ]);

        $this->beConstructedWith($client, 'foobar');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(TinyUrlProvider::class);
    }

    function it_calls_api_with_expected_parameters(HttpClient $client)
    {
        $this->shorten(new Url('https://github.com/andrzejkupczyk/url-shortener'));

        $client->request('create', [
            'form_params' => [
                'format' => 'json',
                'apikey' => 'foobar',
                'provider' => 'tinyurl_com',
                'url' => 'https://github.com/andrzejkupczyk/url-shortener',
            ],
        ])->shouldBeCalled();
    }

    function it_calls_api_with_another_provider_url(HttpClient $client)
    {
        $this->changeProviderUrl('0_mk');
        $this->shorten(new Url('https://github.com/andrzejkupczyk/url-shortener'));

        $client->request('create', [
            'form_params' => [
                'format' => 'json',
                'apikey' => 'foobar',
                'provider' => '0_mk',
                'url' => 'https://github.com/andrzejkupczyk/url-shortener',
            ],
        ])->shouldBeCalled();
    }

    function it_throws_exception_when_url_is_expanded()
    {
        $url = new Url('http://tinyurl.com/uahhqrv');

        $this->shouldThrow(BadMethodCallException::class)->duringExpand($url);
    }
}
