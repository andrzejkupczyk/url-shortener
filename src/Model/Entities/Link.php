<?php

namespace WebGarden\UrlShortener\Model\Entities;

use WebGarden\Model\Entity\Entity;
use WebGarden\Model\ValueObject\StringLiteral\StringLiteral as Id;
use WebGarden\UrlShortener\Model\ValueObjects\Url;

class Link extends Entity
{
    /** @var Id */
    protected $id;

    /** @var Url */
    protected $shortUrl;

    /** @var Url */
    protected $longUrl;

    public function __construct(Id $id, Url $shortUrl, Url $longUrl)
    {
        $this->id = $id;
        $this->shortUrl = $shortUrl;
        $this->longUrl = $longUrl;
    }

    public function shortUrl(): Url
    {
        return $this->shortUrl;
    }

    public function longUrl(): Url
    {
        return $this->longUrl;
    }
}
