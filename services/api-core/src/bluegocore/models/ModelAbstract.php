<?php

namespace BlueGoCore\Models;


use MongoDB\Model\BSONDocument;

abstract class ModelAbstract implements BsonPopulatable {

    /** @var array $modelData */
    protected $modelData = [];

    /**
     * Get an array of the data in this
     * object
     *
     * @return array
     */
    public function getArray()
    {
        $this->ensureUniqueId();
        $responseArray = $this->modelData;
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
        $this->modelData = $array;
    }

    public function getUniqueId()
    {
        if (!isset($this->modelData['uniqueId'])) {
            $this->modelData['uniqueId'] = $this->uuid();
        }
        return $this->modelData['uniqueId'];
    }

    protected function ensureUniqueId()
    {
        if (!isset($this->modelData['uniqueId'])) {
            $this->modelData['uniqueId'] = $this->uuid();
        }
    }

    /**
     * @return string
     * @see http://www.seanbehan.com/how-to-generate-a-uuid-in-php/
     */
    public function uuid()
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}