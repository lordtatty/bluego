<?php

use Slim\Http\Request;
use Slim\Http\Response;

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

        $usersLoader = $blueGoCore->getLoaders()->getUsersLoader();

        $return = [];
        /** @var \BlueGoCore\Models\User $user */
        foreach($usersLoader->iterateAllUsers() as $user){
            $return[] = $user->getArray();
        }

        return $response
            ->withJson($return)
            ->withStatus(200);

    });
