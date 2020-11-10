<?php

declare(strict_types=1);

namespace WebGarden\UrlShortener\Model\Entities;

use WebGarden\Model\Entity\Entity;
use WebGarden\Model\ValueObject\ValueObject;
use WebGarden\UrlShortener\Model\ValueObjects\Url;

final class Link implements Entity
{
    private ValueObject $id;

    private Url $shortUrl;

    private Url $longUrl;

    public function __construct(ValueObject $id, Url $shortUrl, Url $longUrl)
    {
        $this->id = $id;
        $this->shortUrl = $shortUrl;
        $this->longUrl = $longUrl;
    }

    public function identity(): ValueObject
    {
        return $this->id;
    }

    public function shortUrl(): Url
    {
        return $this->shortUrl;
    }

    public function longUrl(): Url
    {
        return $this->longUrl;
    }

    public function sameIdentityAs(Entity $entity): bool
    {
        return $this->identity()->sameValueAs($entity->identity());
    }
}
