<?php

namespace BlueGoCore\Models;

/**
 * Class User
 *
 * Represents an individual user
 * It does not handle the loading or writing of data,
 * see the Loader and Writer classes for that
 *
 * @package BlueGoCore\Models
 */
class User extends ModelAbstract {

    /**
     * Set the User's Forename
     *
     * @param $name
     */
    public function setForename($name) {
        if(!is_string($name)){
            throw new \InvalidArgumentException('$name must be a string, instead found' . var_export($name, true));
        }
        $this->modelData['forename'] = $name;
    }

    /**
     * Get the User's Forename
     *
     * @return string
     */
    public function getForename(){
        if(isset($this->modelData['forename'])){
            return $this->modelData['forename'];
        }
    }

    /**
     * Set the user's surname
     *
     * @param $name
     */
    public function setSurname($name) {
        if(!is_string($name)){
            throw new \InvalidArgumentException('$name must be a string, instead found' . var_export($name, true));
        }
        $this->modelData['surname'] = $name;
    }

    /**
     * Get the user's surname
     *
     * @return string
     */
    public function getSurname(){
        if(isset($this->modelData['surname'])){
            return $this->modelData['surname'];
        }
    }


}