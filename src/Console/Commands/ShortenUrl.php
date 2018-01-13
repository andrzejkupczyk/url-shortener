<?php

namespace WebGarden\UrlShortener\Console\Commands;

use WebGarden\UrlShortener\Model\ValueObjects\Url;
use WebGarden\UrlShortener\UrlShortener;

class ShortenUrl extends Command
{
    protected $description = 'Shorten long URL';

    protected $signature = 'url:shorten {url : The long URL to be shortened}';

    protected function displayLink(UrlShortener $shortener, Url $url)
    {
        $this->alert(sprintf('Short URL: %s', $shortener->shorten($url)->shortUrl()));
    }
}
