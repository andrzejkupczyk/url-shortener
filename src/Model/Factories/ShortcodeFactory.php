<?php

namespace WebGarden\UrlShortener\Model\Factories;

use Godruoyi\Snowflake\Snowflake;
use WebGarden\UrlShortener\Model\ValueObjects\Shortcode;

class ShortcodeFactory
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
