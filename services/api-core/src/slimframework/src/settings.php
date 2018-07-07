<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Monolog settings
        'logger' => [
            'name' => 'api-core',
            'path' => 'php://stdout',
            'level' => \Monolog\Logger::DEBUG,
        ],
    ],
];
