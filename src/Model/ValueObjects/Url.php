<?php

namespace WebGarden\UrlShortener\Model\ValueObjects;

use WebGarden\Model\ValueObject\StringLiteral\StringLiteral;

class Url extends StringLiteral
{
    public function path(): StringLiteral
    {
        return StringLiteral::fromNative(parse_url($this, PHP_URL_PATH));
    }

    protected function assertThat($value)
    {
        return parent::assertThat($value)->url();
    }
}
