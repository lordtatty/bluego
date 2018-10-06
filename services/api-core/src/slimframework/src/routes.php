<?php

// Routes
$app->group('/{instance}', function () {
        $this->group('/users', function (){
                $className = \SlimFramework\Controllers\UsersController::class;
                $this->post('/add', $className . ':addUser');
                $this->patch('/update/{uniqueId}', $className . ':updateUser');
                $this->group('/get', function () use ($className) {
                        $this->get('/all', $className . ':getAll');
                        $this->group('/by', function () use ($className) {
                                $this->get('/id/{uniqueId}', $className . ':getById');
                                $this->get('/course/{uniqueId}', $className . ':getByCourse');
                            });
                    });
            });
        $this->group('/courses', function () {
                $className = \SlimFramework\Controllers\CoursesController::class;
                $this->post('/add', $className . ':addCourse');
                $this->group('/get', function () use ($className) {
                        $this->get('/all', $className . ':getAll');
                        $this->group('/by', function () use ($className) {
//                                $this->get('/id/{uniqueId}', $className . ':getById');
                            });
                    });
            });
        $this->group('/enrollment', function () {
                $className = \SlimFramework\Controllers\EnrollmentController::class;
                $this->post('/add', $className . ':addEnrollment');
                $this->group('/get', function () use ($className) {
                        $this->group('/by', function () use ($className) {
//                                $this->get('/user/{userId}', $className . ':getById');
//                                $this->get('/course/{courseId}', $className . ':getById');
                            });
                    });
            });
    });