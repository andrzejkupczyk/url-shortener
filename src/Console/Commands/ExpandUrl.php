<?php

declare(strict_types=1);

namespace WebGarden\UrlShortener\Console\Commands;

use WebGarden\UrlShortener\Model\ValueObjects\Url;
use WebGarden\UrlShortener\UrlShortener;

class ExpandUrl extends Command
{
    protected $description = 'Expand short URL';

    protected $signature = 'url:expand {url : The short URL to be expanded}';

    public static function providers(): array
    {
        return ['bitly'];
    }

    protected function displayLink(UrlShortener $shortener, Url $url): void
    {
        $expandedUrl = $shortener->expand($url)->longUrl();

        $this->alert("Long URL: {$expandedUrl}");
    }
}
