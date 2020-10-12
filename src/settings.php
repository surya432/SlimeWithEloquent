<?php
return [
    'settings' => [
        'determineRouteBeforeAppMiddleware' => true,
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],
        //mode Debug
        'debug' => false,
        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
        'db' => [
            'driver' => 'mysql',
            'host' =>  '127.0.0.1',
            'database' => 'db1',
            'username' => 'root',
            'password' => 'Pruzz107@',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'port'      => '3306',
        ],
        'db2' => [
            'driver' => 'mysql',
            'host' =>  '127.0.0.1',
            'database' => 'db2',
            'username' => 'root',
            'password' => 'Pruzz107@',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'port'      => '3306',
        ]
    ],
];
