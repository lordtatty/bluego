<?php

namespace BlueGoCore\Models;

/**
 * Class Course
 *
 * Represents an individual course
 * It does not handle the loading or writing of data,
 * see the Reader and Writer classes for that
 *
 * @package BlueGoCore\Models
 */
class Course extends ModelAbstract implements IModelConcrete {

    public function getPodName()
    {
        return 'courses';
    }

    /**
     * Set the Course Title
     *
     * @param $title
     */
    public function setTitle($title) {
        $this->_setModelProperty('title', $title, 'string');
    }

    /**
     * Get the Course Title
     *
     * @return string
     */
    public function getTitle(){
        return $this->_getModelProperty('title');
    }

    /**
     * Set the Course Code
     *
     * @param $title
     */
    public function setCourseCode($title) {
        $this->_setModelProperty('course_code', $title, 'string');
    }

    /**
     * Get the Course Code
     *
     * @return string
     */
    public function getCourseCode(){
        return $this->_getModelProperty('course_code');
    }

    /**
     * Validate the data in the model is
     * safe to store
     *
     * @return bool
     */
    public function validateData(){
        return true;
    }

}