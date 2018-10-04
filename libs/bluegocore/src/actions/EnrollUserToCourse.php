<?php

namespace BlueGoCore\Actions;

use BlueGoCore\Loaders\Views\ViewLoaderFactory;
use BlueGoCore\Models\Course;
use BlueGoCore\Models\User;

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

    /** @var ViewLoaderFactory $viewLoaderFactory */
    private $viewLoaderFactory;
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

    /**
     * Constructor
     * @param ViewLoaderFactory $viewLoaderFactory
     */
    public function __construct(ViewLoaderFactory $viewLoaderFactory){
        $this->viewLoaderFactory = $viewLoaderFactory;
    }

    /**
     * Enrols the user onto the set course
     */
    public function perform(){
        // Update user-course view
        $userCourseView = $this->viewLoaderFactory
            ->getUserCourseViewLoader()
            ->loadFromUser($this->user);
        $userCourseView->addCourse($this->course);

        // Update course_user view
        $courseUserView = $this->viewLoaderFactory
            ->getCourseUserViewLoader()
            ->loadFromCourse($this->course);
        $courseUserView->setCourse($this->course);
        $courseUserView->addUser($this->user);
    }

} 