<?php

// Routes
$app->post('/adduser', \SlimFramework\Controllers\UsersController::class . ':addUser');
$app->get('/getusers', \SlimFramework\Controllers\UsersController::class . ':getUsers');
