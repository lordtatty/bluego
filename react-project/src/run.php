<?php

require __DIR__ . '/vendor/autoload.php';

// Test
$loop = React\EventLoop\Factory::create();

$server = new \React\Http\Server(function (\Psr\Http\Message\ServerRequestInterface $request) {
    return new \React\Http\Response(
        200,
        array(
            'Content-Type' => 'text/plain'
        ),
        "Hello World!\n"
    );
});

$socket = new React\Socket\Server('0.0.0.0:8080', $loop);
$server->listen($socket);

$loop->run();