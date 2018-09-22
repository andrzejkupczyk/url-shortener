<?php

namespace WebGarden\UrlShortener\Model\Factories;

use WebGarden\Model\ValueObject\Number\Natural as Id;
use WebGarden\UrlShortener\Model\ValueObjects\ShortCode;

abstract class ShortCodeGenerator
{
    /**
     * Generate a new short code.
     *
     * @param  Id $id
     * @return ShortCode
     */
    public static function createFromId(Id $id): ShortCode
    {
        return ShortCode::fromNative(static::generate($id));
    }

    /**
     * Generate a native short code using the given Id.
     *
     * @param  Id $id
     * @return string
     */
    abstract protected static function generate(Id $id): string;
}
