<?php

// Routes
$app->group('/{instance}', function () {
        $this->group('/users', function (){
                $className = \SlimFramework\Controllers\UsersController::class;
                $this->post('/add', $className . ':addUser');
                $this->post('/update/{uniqueId}', $className . ':updateUser');
                $this->group('/get', function () use ($className) {
                        $this->get('/all', $className . ':getUsers');
                    });

            });
        $this->group('/courses', function () {
                $className = \SlimFramework\Controllers\CoursesController::class;
                $this->post('/add', $className . ':addCourse');
                $this->get('/getall', $className . ':getCourses');
            });
    });