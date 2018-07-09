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
class CourseUserView extends ViewsAbstract {

    /**
     * Set the User's Forename
     *
     * @param User $user
     */
    public function setCourse(Course $course) {
        $this->setUniqueId($course->getUniqueId());
        $this->_setModelProperty('course', $course, 'iModel');
    }

    /**
     * Get the User's Forename
     *
     * @return string
     */
    public function getUsers(){
        return $this->_getModelProperty('users');
    }

    /**
     * Set the user's surname
     *
     * @param Course $course
     */
    public function addUser(User $user) {
        $this->addModelToViewArray('users', $user);
   }

    /**
     * Get the user's surname
     *
     * @return string
     */
    public function getCourse(){
        return $this->_getModelProperty('course');
    }

    public function getPodName()
    {
        return 'view_course_users';
    }
}