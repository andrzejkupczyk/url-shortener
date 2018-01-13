<?php

namespace WebGarden\UrlShortener\Model\Factories;

use WebGarden\Model\ValueObject\Number\Natural as Id;
use WebGarden\UrlShortener\Model\ValueObjects\ShortCode;

abstract class ShortCodeGenerator
{
    public static function createFromId(Id $id): ShortCode
    {
        return ShortCode::fromNative(static::generate($id));
    }

    abstract protected static function generate(Id $id): string;
}
