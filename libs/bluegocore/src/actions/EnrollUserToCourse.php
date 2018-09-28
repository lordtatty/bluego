<?php

namespace BlueGoCore\Actions;

use BlueGoCore\Models\Course;
use BlueGoCore\Models\User;
use BlueGoCore\Models\Views\CourseUserView;
use BlueGoCore\Models\Views\UserCourseView;
use BlueGoCore\Storage\StorageManager;

/**
 * Enrolls a user on to a course.
 *
 * It's recommended to use the ActionsFactory
 * to get an instance of this Action
 *
 * Class EnrollUserToCourse
 * @package BlueGoCore\Actions
 */
class EnrollUserToCourse {

    /** @var StorageManager $storageManager */
    private $storageManager;
    /** @var User $user */
    private $user;
    /** @var Course $courses */
    private $course;

    /** @var UserCourseView  */
    private $userCourseView;
    /** @var CourseUserView  */
    private $courseUserView;


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

    public function __construct(StorageManager $storageManager, UserCourseView $userCourseView, CourseUserView $courseUserView){
        $this->storageManager = $storageManager;
        $this->userCourseView = $userCourseView;
        $this->courseUserView = $courseUserView;
    }

    public function perform(){
        //Ensure the user is not already enrolled on this course
        // TODO: As above


        // Create user-course view
        $this->userCourseView->addCourse($this->course);
        $this->userCourseView->setUser($this->user);
        $this->storageManager->addModel($this->userCourseView);

        // Create course_user view
        $this->courseUserView->setCourse($this->course);
        $this->courseUserView->addUser($this->user);
        $this->storageManager->addModel($this->courseUserView);
    }



} 