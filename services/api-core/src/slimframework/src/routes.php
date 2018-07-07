<?php

// Routes
$app->group('/{instance}', function () {
        $this->post('/users/add', \SlimFramework\Controllers\UsersController::class . ':addUser');
        $this->get('/users/getall', \SlimFramework\Controllers\UsersController::class . ':getUsers');
        $this->post('/addcourse', \SlimFramework\Controllers\CoursesController::class . ':addCourse');
    });