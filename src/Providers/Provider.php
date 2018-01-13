<?php

namespace WebGarden\UrlShortener\Providers;

use WebGarden\UrlShortener\Model\Entities\Link;
use WebGarden\UrlShortener\Model\ValueObjects\Url;

interface Provider
{
    public function expand(Url $shortUrl): Link;

    public function shorten(Url $longUrl): Link;
}
