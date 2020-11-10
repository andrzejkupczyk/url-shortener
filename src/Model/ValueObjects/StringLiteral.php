<?php

declare(strict_types=1);

namespace WebGarden\UrlShortener\Model\ValueObjects;

use WebGarden\Model\ValueObject\SimpleComparison;
use WebGarden\Model\ValueObject\ValueObject;

/**
 * @psalm-immutable
 */
class StringLiteral implements ValueObject
{
    use SimpleComparison;

    protected string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
