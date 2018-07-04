<?php

// Routes
$app->group('/{instance}', function () {
        $this->post('/adduser', \SlimFramework\Controllers\UsersController::class . ':addUser');
        $this->get('/getusers', \SlimFramework\Controllers\UsersController::class . ':getUsers');
    });