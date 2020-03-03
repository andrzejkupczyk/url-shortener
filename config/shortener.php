<?php

return [
    'providers' => [
        'bitly' => [
            'api_uri' => 'https://api-ssl.bitly.com/v4/',
            'api_key' => '',
            'domain' => 'bit.ly',
        ],
        'firebase' => [
            'api_uri' => 'https://firebasedynamiclinks.googleapis.com/v1/',
            'api_key' => '',
            'domain' => 'example.page.link',
            'unguessable' => true,
        ],
        'tinyUrl' => [
            'api_uri' => 'http://tiny-url.info/api/v1/',
            'api_key' => '',
        ],
    ],
];
