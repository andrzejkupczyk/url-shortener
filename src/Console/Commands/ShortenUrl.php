<?php

declare(strict_types=1);

namespace WebGarden\UrlShortener\Console\Commands;

use WebGarden\UrlShortener\Model\ValueObjects\Url;
use WebGarden\UrlShortener\UrlShortener;

class ShortenUrl extends Command
{
    protected $description = 'Shorten long URL';

    protected $signature = 'url:shorten {url : The long URL to be shortened}';

    protected function displayLink(UrlShortener $shortener, Url $url): void
    {
        $shortenedUrl = $shortener->shorten($url)->shortUrl();

        $this->alert("Short URL: {$shortenedUrl}");
    }
}
