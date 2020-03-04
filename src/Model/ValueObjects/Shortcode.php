<?php

declare(strict_types=1);

namespace WebGarden\UrlShortener\Model\ValueObjects;

final class Shortcode extends StringLiteral
{
    private const CHARS = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    protected function assertThat($value)
    {
        return parent::assertThat($value)->regex('/[' . self::CHARS . ']+/');
    }
}
