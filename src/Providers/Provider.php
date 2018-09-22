<?php

namespace WebGarden\UrlShortener\Providers;

use WebGarden\UrlShortener\Model\Entities\Link;
use WebGarden\UrlShortener\Model\ValueObjects\Url;

interface Provider
{
    /**
     * Expand a short URL.
     *
     * @param  Url $shortUrl
     * @return Link
     */
    public function expand(Url $shortUrl): Link;

    /**
     * Shorten a long URL.
     *
     * @param  Url $longUrl
     * @return Link
     */
    public function shorten(Url $longUrl): Link;
}
