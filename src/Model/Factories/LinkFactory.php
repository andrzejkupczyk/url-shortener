<?php

namespace WebGarden\UrlShortener\Model\Factories;

use WebGarden\Model\ValueObject\StringLiteral\StringLiteral as Id;
use WebGarden\UrlShortener\Model\Entities\Link;
use WebGarden\UrlShortener\Model\ValueObjects\Url;

class LinkFactory
{
    public static function create(string $id, string $shortUrl, string $longUrl): Link
    {
        return new Link(
            Id::fromNative($id),
            Url::fromNative($shortUrl),
            Url::fromNative($longUrl)
        );
    }

    /**
     * @param  object|array $row
     * @return Link
     */
    public static function createFromRow($row): Link
    {
        $row = (object) $row;

        return static::create($row->id, $row->short_url, $row->long_url);
    }
}
