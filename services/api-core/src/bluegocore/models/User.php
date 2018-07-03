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

    public function setName($name) {
        if(!is_string($name)){
            throw new \InvalidArgumentException('$name must be a string, instead found' . var_export($name, true));
        }
        $this->userData['name'] = $name;
    }

    public function getName(){
        if(isset($this->userData['name'])){
            return $this->userData['name'];
        }
    }

    public function setAge($age) {
        // Todo: remove this - unnecessary field, just interesting for testing
        if(!is_int($age)){
            throw new \InvalidArgumentException('$name must be an integer, instead found' . var_export($age, true));
        }
        $this->userData['age'] = $age;
    }

    public function getUniqueId() {
        $this->ensureUniqueId();
        return $this->userData['uniqueId'];
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