<?php

namespace BlueGoCore\Models;

use MongoDB\Model\BSONDocument;

/**
 * Class User
 *
 * Represents an individual user
 * It does not handle the loading or writing of data,
 * see the Loader and Writer classes for that
 *
 * @package BlueGoCore\Models
 */
class User implements BsonPopulatable{

    protected $userData = [];

    /**
     * Get an array of the data in this
     * object
     *
     * @return array
     */
    public function getArray(){
        $this->ensureUniqueId();
        $responseArray = $this->userData;
        unset($responseArray['_id']);
        return $responseArray;
    }

    /**
     * Populate this object via a MongoDb BSON Object
     *
     * @param BSONDocument $bson
     */
    public function setByBson(BSONDocument $bson)
    {
        $this->setByArray((array)$bson);
    }

    /**
     * Populate this object via an array
     *
     * @param array $array
     */
    public function setByArray(array $array)
    {
        $this->userData = $array;
    }

    public function setForename($name) {
        if(!is_string($name)){
            throw new \InvalidArgumentException('$name must be a string, instead found' . var_export($name, true));
        }
        $this->userData['forename'] = $name;
    }

    public function getForename(){
        if(isset($this->userData['forename'])){
            return $this->userData['forename'];
        }
    }

    public function setSurname($name) {
        if(!is_string($name)){
            throw new \InvalidArgumentException('$name must be a string, instead found' . var_export($name, true));
        }
        $this->userData['surname'] = $name;
    }

    public function getSurname(){
        if(isset($this->userData['surname'])){
            return $this->userData['surname'];
        }
    }

    public function getUniqueId(){
        if(isset($this->userData['uniqueId'])){
            return $this->userData['uniqueId'];
        }
    }

    protected function ensureUniqueId(){
        if(!isset($this->userData['uniqueId'])){
            $this->userData['uniqueId'] = $this->uuid();
        }
    }

    /**
     * TODO: Move this out of here, perhaps to a parent class
     * @return string
     * @see http://www.seanbehan.com/how-to-generate-a-uuid-in-php/
     */
    public function uuid(){
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

}