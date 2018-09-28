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
        // TODO: Try to load an existing View
    }

    /**
     * Get the User's Forename
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
     * @return string
     */
    public function getCourses(){
        return $this->_getModelProperty('courses');
    }

    public function getPodName()
    {
        return 'view_user_course';
    }
}