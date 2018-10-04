<?php

namespace BlueGoCore\Actions;

use BlueGoCore\Loaders\Views\CourseUserViewLoader;
use BlueGoCore\Loaders\Views\UserCourseViewLoader;
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
    /** @var UserCourseViewLoader $userCourseViewLoader */
    private $userCourseViewLoader;
    /** @var CourseUserViewLoader $courseUserViewLoader */
    private $courseUserViewLoader;
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

    public function __construct(StorageManager $storageManager, UserCourseViewLoader $userCourseViewLoader, CourseUserViewLoader $courseUserViewLoader){
        $this->storageManager = $storageManager;
        $this->userCourseViewLoader = $userCourseViewLoader;
        $this->courseUserViewLoader = $courseUserViewLoader;
    }

    public function perform(){
        //Ensure the user is not already enrolled on this course
        // TODO: As above

        // Create user-course view
        $userCourseView = $this->userCourseViewLoader->loadFromUser($this->user);
        $userCourseView->addCourse($this->course);
        $this->storageManager->addModel($userCourseView);

        $courseUserView = $this->courseUserViewLoader->loadFromCourse($this->course);
        // Create course_user view
        $courseUserView->setCourse($this->course);
        $courseUserView->addUser($this->user);
        $this->storageManager->addModel($courseUserView);
    }



} 