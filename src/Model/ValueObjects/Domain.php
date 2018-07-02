<?php

namespace WebGarden\UrlShortener\Model\ValueObjects;

use WebGarden\Model\ValueObject\StringLiteral\StringLiteral;

class Domain extends StringLiteral
{
    protected const PATTERN = '/^(?!:\/\/)([a-z0-9-_]+\.)*[a-z0-9][a-z0-9-_]+\.[a-z]{2,11}?$/i';

    protected function assertThat($value)
    {
        return parent::assertThat($value)->regex(self::PATTERN);
    }
}
