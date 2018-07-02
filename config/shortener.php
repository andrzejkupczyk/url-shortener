<?php

return [
    'providers' => [
        'eloquent' => [
            'base_url' => 'http://localhost',
            'connection' => 'mysql',
            'table' => 'links',
        ],
        'firebase' => [
            'api_key' => 'YOUR_API_KEY',
            'domain' => 'example.page.link',
            'unguessable' => true,
        ],
        'google' => [
            'api_key' => 'YOUR_API_KEY',
        ],
        'tinyUrl' => [
            'api_key' => 'YOUR_API_KEY',
        ],
    ],
];
