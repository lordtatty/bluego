<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/adduser/{name}', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/adduser' route");

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
        $this->logger->info("Slim-Skeleton '/adduser' route");

        $mongodb = new \MongoDB\Client("mongodb://mongodb:27017");
        $db = $mongodb->selectDatabase("test");
        $collection = $db->selectCollection("testcollection");
        $result = $collection->find();

        /** @var MongoDB\Model\BSONDocument $r */
        $return = [];
        foreach($result as $r){
            $return[] = $r;
        }

        return $response->withJson($return)
            ->withStatus(200);

    });
