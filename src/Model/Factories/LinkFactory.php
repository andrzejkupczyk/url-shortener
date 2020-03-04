<?php

namespace WebGarden\UrlShortener\Model\Factories;

use WebGarden\UrlShortener\Model\Entities\Link;
use WebGarden\UrlShortener\Model\ValueObjects\StringLiteral;
use WebGarden\UrlShortener\Model\ValueObjects\Url;

/**
 * @internal the class is used by the providers to create the Link object from the api response
 */
final class LinkFactory
{
    public static function create(string $id, string $shortUrl, string $longUrl): Link
    {
        return new Link(new StringLiteral($id), new Url($shortUrl), new Url($longUrl));
    }
}
