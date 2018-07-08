<?php

namespace BlueGoCore\Models;

/**
 * Class User
 *
 * Represents an individual user
 * It does not handle the loading or writing of data,
 * see the Reader and Writer classes for that
 *
 * @package BlueGoCore\Models
 */
class User extends ModelAbstract {

    /**
     * Set the User's Forename
     *
     * @param $forename
     */
    public function setForename($forename) {
        $this->_setModelProperty('forename', $forename, 'string');
    }

    /**
     * Get the User's Forename
     *
     * @return string
     */
    public function getForename(){
        return $this->_getModelProperty('forename');
    }

    /**
     * Set the user's surname
     *
     * @param $surname
     */
    public function setSurname($surname) {
        $this->_setModelProperty('surname', $surname, 'string');
   }

    /**
     * Get the user's surname
     *
     * @return string
     */
    public function getSurname(){
        return $this->_getModelProperty('surname');
    }


    public function getPodName()
    {
        return 'users';
    }
}