<?php declare(strict_types=1);

namespace WebGarden\UrlShortener\Model\ValueObjects;

final class Url extends StringLiteral
{
    public function path(): StringLiteral
    {
        $urlPath = (string) parse_url($this->value, PHP_URL_PATH);

        return new StringLiteral($urlPath);
    }

    protected function assertThat($value)
    {
        return parent::assertThat($value)->url();
    }
}
