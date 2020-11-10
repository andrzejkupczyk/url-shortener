<?php

declare(strict_types=1);

namespace WebGarden\UrlShortener\Model\ValueObjects;

use Assert\Assert;

/**
 * @psalm-immutable
 */
final class Shortcode extends StringLiteral
{
    private const CHARS = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    public function __construct(string $value)
    {
        Assert::that($value)->regex('/[' . self::CHARS . ']+/');

        parent::__construct($value);
    }
}
