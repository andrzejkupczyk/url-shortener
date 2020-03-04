<?php

return [
    'providers' => [
        'bitly' => [
            'api_uri' => 'https://api-ssl.bitly.com/v4/',
            'api_key' => env('BITLY_API_KEY'),
            'domain' => 'bit.ly',
        ],
        'firebase' => [
            'api_uri' => 'https://firebasedynamiclinks.googleapis.com/v1/',
            'api_key' => env('FIREBASE_API_KEY'),
            'domain' => 'example.page.link',
            'unguessable' => true,
        ],
        'tinyUrl' => [
            'api_uri' => 'http://tiny-url.info/api/v1/',
            'api_key' => env('TINYURL_API_KEY'),
        ],
    ],
];
