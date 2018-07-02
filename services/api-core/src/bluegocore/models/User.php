<?php

namespace BlueGoCore\Models;

use MongoDB\Model\BSONDocument;

class User implements BsonPopulatable{

    protected $userData = [];

    /**
     * Get an array of the data in this
     * object
     *
     * @return array
     */
    public function getArray(){
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
        $this->userData = (array)$bson;
    }

    public function setName($name) {
        if(!is_string($name)){
            throw new \InvalidArgumentException('$name must be a string, instead found' . var_export($name, true));
        }
        $this->userData['name'] = $name;
    }

    public function setAge($age) {
        if(!is_int($age)){
            throw new \InvalidArgumentException('$name must be an integer, instead found' . var_export($age, true));
        }
        $this->userData['age'] = $age;
    }


}