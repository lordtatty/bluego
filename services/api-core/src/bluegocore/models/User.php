<?php

namespace BlueGoCore\Models;

use MongoDB\Model\BSONDocument;

class User implements BsonPopulatable{

    protected $userData;

    public function getArray(){
        return $this->userData;
    }

    public function setByBson(BSONDocument $bson)
    {
        $this->userData = (array)$bson;
    }
}