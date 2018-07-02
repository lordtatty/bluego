<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/adduser/{name}', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("BlueGo '/adduser' route");

    $route = $request->getAttribute('route');
    $name = $route->getArgument('name');

    $data = array('name' => $name, 'age' => 40);

    $mongodb = new \MongoDB\Client("mongodb://mongodb:27017");
    $db = $mongodb->selectDatabase("test");
    $collection = $db->selectCollection("testcollection");
    $collection->insertOne($data);

    return $response->withStatus(200);

});

$app->get('/getusers', function (Request $request, Response $response, array $args) {
        // Sample log message
        $this->logger->info("BlueGo '/adduser' route");

        $blueGoCore = new \BlueGoCore\BlueGoCore();
        $usersLoader = $blueGoCore->getLoaders()->getUsersLoader();

        $return = [];
        /** @var \BlueGoCore\Models\User $user */
        foreach($usersLoader->iterateAllUsers() as $user){
            $return[] = $user->getArray();
        }

        return $response->withJson($return)
            ->withStatus(200);

    });
