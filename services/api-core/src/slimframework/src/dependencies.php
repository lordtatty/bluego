<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

$container['errorHandler'] = function ($container) {
    return function ($request, $response, $exception) use ($container) {

        /** @var Monolog\Logger $logger */
        $logger = $container->get('logger');
        /** @var \Exception $exception */
        $logMessage = $exception->getMessage() . "::" . "File: " . $exception->getFile() . "::" . "Line: " . $exception->getLine();
        $logger->error($logMessage);
        $logger->error($exception->getTraceAsString());

        // Parse it with the json api library
        $errors = new \Tobscure\JsonApi\ErrorHandler();
        $errors->registerHandler(new \Tobscure\JsonApi\Exception\Handler\InvalidParameterExceptionHandler());
        $errors->registerHandler(new \Tobscure\JsonApi\Exception\Handler\FallbackExceptionHandler(false));
        $response = $errors->handle($exception);

        $document = new \Tobscure\JsonApi\Document();
        $document->setErrors($response->getErrors());

        // Return it with slim
        return $container['response']->withStatus($response->getStatus())
            ->withHeader('Content-Type', 'application/json')
            ->withJson($document->toArray());
    };
};