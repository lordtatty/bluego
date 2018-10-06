<?php

namespace BlueGoCore\Actions;

use BlueGoCore\Loaders\IModelLoader;
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
        // Sanity Checks
        if(($this->user) === null){
            throw new \Exception('User is not set');
        }
        if(($this->course) === null){
            throw new \Exception('Course is not set');
        }
        // Update user-course view
        $userCourseView = $this->getUserCourseView($this->user->getUniqueId());
        $userCourseView->setUser($this->user);
        $userCourseView->addCourse($this->course);

        // Update course_user view
        $courseUserView = $this->getCourseUserView($this->course->getUniqueId());
        $courseUserView->setCourse($this->course);
        $courseUserView->addUser($this->user);
    }

    /**
     * Get A user course view.  Populated by the ID if it
     * exists, otherwise blank.
     *
     * @param $id
     * @return User|\BlueGoCore\Models\Views\UserCourseView
     */
    protected function getUserCourseView($id){
        $loader = $this->viewLoaderFactory
            ->getUserCourseViewLoader();
        return $this->getViewFromLoader($loader, $id);
    }

    /**
     * @param $id
     * @return User|\BlueGoCore\Models\Views\CourseUserView
     */
    protected function getCourseUserView($id){
        $loader = $this->viewLoaderFactory
            ->getCourseUserViewLoader();
        return $this->getViewFromLoader($loader, $id);
    }

    protected function getViewFromLoader(IModelLoader $loader, $id){
        $view = $loader->getByUniqueId($id);
        if($view == null){
            $view = $loader->createNew();
        }
        return $view;
    }

} 