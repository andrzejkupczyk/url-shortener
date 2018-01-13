<?php

namespace WebGarden\UrlShortener\Model\ValueObjects;

use WebGarden\Model\ValueObject\StringLiteral\StringLiteral;

class Url extends StringLiteral
{
    /**
     * {@inheritDoc}
     */
    protected function assertThat($value)
    {
        return parent::assertThat($value)->url();
    }
}
