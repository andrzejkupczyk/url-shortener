<?php

namespace WebGarden\UrlShortener\Model\ValueObjects;

use WebGarden\Model\ValueObject\StringLiteral\StringLiteral;

class ShortCode extends StringLiteral
{
    /** @var string The characters used in building the short URL */
    const ALLOWED_CHARS = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    protected function assertThat($value)
    {
        return parent::assertThat($value)->regex('/[' . static::ALLOWED_CHARS . ']+/');
    }
}
