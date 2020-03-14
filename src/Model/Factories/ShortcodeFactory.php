<?php

declare(strict_types=1);

namespace WebGarden\UrlShortener\Model\Factories;

use Godruoyi\Snowflake\Snowflake;
use WebGarden\UrlShortener\Model\ValueObjects\Shortcode;

final class ShortcodeFactory
{
    /**
     * @see https://developer.twitter.com/en/docs/basics/twitter-ids
     */
    public static function createUsingSnowflake(): Shortcode
    {
        $snowflake = new Snowflake();

        return new Shortcode((string) $snowflake->id());
    }
}
