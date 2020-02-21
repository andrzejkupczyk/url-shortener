<?php

namespace WebGarden\UrlShortener\Model\ValueObjects;

use WebGarden\Model\ValueObject\StringLiteral\StringLiteral;

class Shortcode extends StringLiteral
{
    protected const CHARS = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    protected function assertThat($value)
    {
        return parent::assertThat($value)->regex('/[' . static::CHARS . ']+/');
    }
}
