<?php

declare(strict_types=1);

namespace WebGarden\UrlShortener\Model\ValueObjects;

use Assert\Assert;

/**
 * @psalm-immutable
 */
final class Url extends StringLiteral
{
    public function __construct(string $value)
    {
        Assert::that($value)->url();

        parent::__construct($value);
    }

    public function path(): StringLiteral
    {
        $urlPath = (string) parse_url($this->value, PHP_URL_PATH);

        return new StringLiteral($urlPath);
    }
}
