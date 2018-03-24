<?php

namespace WebGarden\UrlShortener\Model\Factories;

use WebGarden\Model\ValueObject\Number\Natural as Id;
use WebGarden\UrlShortener\Model\Entities\Link;
use WebGarden\UrlShortener\Model\ValueObjects\Url;

class LinkFactory
{
    /**
     * @param  int    $id
     * @param  string $shortUrl
     * @param  string $longUrl
     *
     * @return Link
     */
    public static function create($id, $shortUrl, $longUrl): Link
    {
        return new Link(
            Id::fromNative((int) $id),
            Url::fromNative((string) $shortUrl),
            Url::fromNative((string) $longUrl)
        );
    }

    /**
     * @param  object|array $row
     *
     * @return Link
     */
    public static function createFromRow($row): Link
    {
        $row = (object) $row;

        return static::create($row->id, $row->short_url, $row->long_url);
    }
}
