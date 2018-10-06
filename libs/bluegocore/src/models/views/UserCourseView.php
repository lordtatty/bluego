<?php

namespace BlueGoCore\Models\Views;

use BlueGoCore\Models\Course;
use BlueGoCore\Models\User;

/**
 * Class User
 *
 * Represents an individual user
 * It does not handle the loading or writing of data,
 * see the Reader and Writer classes for that
 *
 * @package BlueGoCore\Models
 */
class UserCourseView extends ViewsAbstract {
    /**
     * Set the User's Forename
     *
     * @param User $user
     */
    public function setUser(User $user) {
        $this->setUniqueId($user->getUniqueId());
        $this->_setModelProperty('user', $user, 'iModel');
    }

    /**
     * Get the Users
     *
     * @return string
     */
    public function getUser(){
        return $this->_getModelProperty('user');
    }

    /**
     * Set the user's surname
     *
     * @param Course $course
     */
    public function addCourse(Course $course) {
        $this->addModelToViewArray('courses', $course);
   }

    /**
     * Get the user's surname
     *
     * @return Generator|Course[]
     */
    public function getCourses(){
        foreach($this->_getModelProperty('courses') as $userArr){
            $course = new Course();
            $course->loadFromArray($userArr);
            yield $course;
        }
    }

    /**
     * Validate the data in the model is
     * safe to store
     *
     * @return bool
     */
    public function validateData(){
        $user = $this->_getModelProperty('user');
        if (!isset($user) || empty($user)) {
            return false;
        }
        return true;
    }

    public function getPodName()
    {
        return 'view_user_course';
    }
}