<?php

return [
    'providers' => [
        'eloquent' => [
            'base_url' => 'http://localhost',
            'connection' => 'mysql',
            'table' => 'links',
        ],
        'google' => [
            'api_key' => 'YOUR_API_KEY',
        ],
        'tinyUrl' => [
            'api_key' => 'YOUR_API_KEY',
        ],
    ],
];
