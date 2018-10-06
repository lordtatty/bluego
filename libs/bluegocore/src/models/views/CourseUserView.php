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
     * @param Course $course
     */
    public function setCourse(Course $course) {
        $this->setUniqueId($course->getUniqueId());
        $this->_setModelProperty('course', $course, 'iModel');
    }

    /**
     * Get the User's Forename
     *
     * @return Generator|User[]
     */
    public function getUsers(){
        foreach($this->_getModelProperty('users') as $userArr){
            $user = new User();
            $user->loadFromArray($userArr);
            yield $user;
        }
    }

    /**
     * Set the user's surname
     *
     * @param User $user
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

    /**
     * Validate the data in the model is
     * safe to store
     *
     * @return bool
     */
    public function validateData(){
        $course = $this->_getModelProperty('course');
        if (!isset($course) || empty($course)) {
            return false;
        }
        return true;
    }

    public function getPodName()
    {
        return 'view_course_users';
    }
}