<?php

declare(strict_types=1);

namespace WebGarden\UrlShortener\Model\ValueObjects;

use Assert\Assert;

/**
 * @psalm-immutable
 */
final class Domain extends StringLiteral
{
    private const PATTERN = '/^(?!:\/\/)([a-z0-9-_]+\.)*[a-z0-9][a-z0-9-_]+\.[a-z]{2,11}?$/i';

    public function __construct(string $value)
    {
        Assert::that($value)->regex(self::PATTERN);

        parent::__construct($value);
    }
}
