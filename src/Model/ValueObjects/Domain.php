<?php declare(strict_types=1);

namespace WebGarden\UrlShortener\Model\ValueObjects;

final class Domain extends StringLiteral
{
    private const PATTERN = '/^(?!:\/\/)([a-z0-9-_]+\.)*[a-z0-9][a-z0-9-_]+\.[a-z]{2,11}?$/i';

    protected function assertThat($value)
    {
        return parent::assertThat($value)->regex(self::PATTERN);
    }
}
