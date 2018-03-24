<?php

namespace WebGarden\UrlShortener\Console\Commands;

use WebGarden\UrlShortener\Model\ValueObjects\Url;
use WebGarden\UrlShortener\UrlShortener;

class ExpandUrl extends Command
{
    protected $description = 'Expand short URL';

    protected $signature = 'url:expand {url : The short URL to be expanded}';

    public function providers(): array
    {
        return ['google', 'eloquent'];
    }

    protected function displayLink(UrlShortener $shortener, Url $url)
    {
        $this->alert(sprintf('Long URL: %s', $shortener->expand($url)->longUrl()));
    }
}
