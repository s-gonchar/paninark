<?php

return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
        ],
        'doctrine' => [
            'meta' => [
                'entity_path' => [
                    __DIR__ . '/../config/doctrine'
                ],
                'auto_generate_proxies' => true,
                'proxy_dir' => __DIR__ . '/../cache/proxies',
                'cache' => null,
            ],
            'connection' => [
                'driver' => 'pdo_mysql',
                'host' => 'mysql',
                'dbname' => 'slim',
                'user' => 'dbuser',
                'password' => 'password',
                'port' => 3306
            ]
        ],
        'redis' => [
            'connection' => [
                'host' => 'localhost',
                'port' => 6379
            ]
        ]
    ],
];
