<?php

namespace WebGarden\UrlShortener\Model\Factories;

use WebGarden\Model\ValueObject\Number\Natural as Id;
use WebGarden\UrlShortener\Model\ValueObjects\ShortCode;

class ShortCodeFactory extends ShortCodeGenerator
{
    protected static function generate(Id $id, string $chars = ShortCode::ALLOWED_CHARS): string
    {
        $integer = $id->toNative() + 10000;
        $length = strlen($chars);
        $code = '';

        while ($integer > $length - 1) {
            $code = $chars[$integer % $length] . $code;
            $integer = intdiv($integer, $length);
        }

        return $chars[$integer] . $code;
    }
}
