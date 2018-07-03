<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Tobscure\JsonApi\Document;
use Tobscure\JsonApi\Collection;

// Routes

$blueGoCore = new \BlueGoCore\BlueGoCore();

$app->post('/adduser', function (Request $request, Response $response, array $args) use ($blueGoCore) {
        // Sample log message
        $this->logger->info("BlueGo '/adduser' route");

        $user = new \BlueGoCore\Models\User();
        $user->setName($request->getParam('name'));
        $user->setAge($request->getParam('age'));

        $writer = $blueGoCore->getWriters()->getUsersWriter();
        $writer->saveToDb($user);

        return $response
            ->withStatus(200);

    });

$app->get('/getusers', function (Request $request, Response $response, array $args) use ($blueGoCore) {
        // Sample log message
        $this->logger->info("BlueGo '/adduser' route");

        $allUsers = $blueGoCore->getLoaders()->getUsersLoader()->getAllUsers();

        // Create a new collection of posts, and specify relationships to be included.
        $collection = (new Collection($allUsers, new \JsonApi\Tobscure\Serialisers\UserSerialiser()))
            ->with(['author', 'comments']);

        // Create a new JSON-API document with that collection as the data.
        $document = new Document($collection);

        // Add metadata and links.
        $document->addMeta('total', count($allUsers));
        $uri = $request->getUri();
        $document->addLink('self', $uri->getScheme() . '://' . $uri->getHost() . $uri->getPort() . $uri->getPath());

        return $response
            ->withJson($document)
            ->withHeader('Content-Type', 'application/vnd.api+json')
            ->withStatus(200);

    });
