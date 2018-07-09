<?php

namespace BlueGoCore\Actions;

use BlueGoCore\Models\Course;
use BlueGoCore\Models\User;
use BlueGoCore\Models\Views\CourseUserView;
use BlueGoCore\Models\Views\UserCourseView;
use BlueGoCore\Storage\StorageManager;


class EnrollUserToCourse {

    /** @var StorageManager $storageManager */
    private $storageManager;
    /** @var User $user */
    private $user;
    /** @var Course $courses */
    private $course;


    /**
     * @param Course $course
     */
    public function setCourse(Course $course)
    {
        $this->course = $course;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function __construct(StorageManager $storageManager){
        $this->storageManager = $storageManager;

    }

    public function perform(){
        $userCourseView = new UserCourseView();
        $courseUserView = new CourseUserView();

        // Create user-course view
        $userCourseView->addCourse($this->course);
        $userCourseView->setUser($this->user);
        $this->storageManager->addModel($userCourseView);

        $courseUserView->setCourse($this->course);
        $courseUserView->addUser($this->user);
        $this->storageManager->addModel($courseUserView);

    }



} 