<?php

declare(strict_types=1);

namespace WebGarden\UrlShortener\Model\ValueObjects;

use Assert\Assert;
use WebGarden\Model\ValueObject\Comparability;
use WebGarden\Model\ValueObject\ValueObject;

class StringLiteral implements ValueObject
{
    use Comparability;

    /** @var string */
    protected $value;

    /**
     * @param string $value
     */
    final public function __construct($value)
    {
        $this->assertThat($value);

        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     *
     * @return \Assert\AssertionChain
     */
    protected function assertThat($value)
    {
        return Assert::that($value)->string();
    }
}
