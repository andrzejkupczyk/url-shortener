<?php

namespace spec\WebGarden\UrlShortener\Providers;

use WebGarden\UrlShortener\Model\Entities\Link;

trait LinkIdentityMatcher
{
    function getMatchers(): array
    {
        return [
            'haveSameIdentity' => function (Link $link1, Link $link2) {
                return $link1->sameIdentityAs($link2);
            },
        ];
    }
}
