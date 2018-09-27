<?php

// Routes
$app->group('/{instance}', function () {
        $this->group('/users', function (){
                $className = \SlimFramework\Controllers\UsersController::class;
                $this->post('/add', $className . ':addUser');
                $this->post('/update/{uniqueId}', $className . ':updateUser');
                $this->get('/getall', $className . ':getUsers');

            });
        $this->group('/courses', function () {
                $className = \SlimFramework\Controllers\CoursesController::class;
                $this->post('/add', $className . ':addCourse');
                $this->get('/getall', $className . ':getCourses');
            });
    });