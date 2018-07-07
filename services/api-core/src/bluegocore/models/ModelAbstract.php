<?php

namespace BlueGoCore\Models;


use MongoDB\Model\BSONDocument;

abstract class ModelAbstract implements BsonPopulatable {

    /** @var array $modelData */
    private $modelData = [];

    /**
     * Get an array of the data in this
     * object
     *
     * @return array
     */
    public function getArray()
    {
        $this->_ensureUniqueId();
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

    /**
     * Get a unique ID for this object
     *
     * If no unique ID is currently assigned then
     * one will be created
     *
     * @return mixed
     */
    public function getUniqueId()
    {
        $this->_ensureUniqueId();
        return $this->modelData['uniqueId'];
    }

    /**
     * Ensure this object has a unique ID;
     */
    protected function _ensureUniqueId()
    {
        if (!isset($this->modelData['uniqueId'])) {
            $this->modelData['uniqueId'] = $this->_generateUuid();
        }
    }

    /**
     * Set a property of the model
     *
     * @param $key
     * @param $value
     * @param $type
     */
    protected function _setModelProperty($key, $value, $type) {

        switch($type) {
            case 'string':
                if(!is_string($value)){
                    throw new \InvalidArgumentException('$name must be a string, instead found: ' . var_export($value, true));
                }
                break;
            case 'int':
                if(!is_int($value)){
                    throw new \InvalidArgumentException('$name must be an integer, instead found: ' . var_export($value, true));
                }
                break;
            case 'bool':
                if(!is_bool($value)){
                    throw new \InvalidArgumentException('$name must be a boolean, instead found: ' . var_export($value, true));
                }
                break;
            default:
                throw new \InvalidArgumentException('unknown $type value passed, found:' . var_export($value, true));
        }

        $this->modelData[$key] = $value;
    }

    /**
     * Get a model property
     *
     * @param $key
     * @return null
     */
    protected function _getModelProperty($key) {
        if(isset($this->modelData[$key])) {
            return $this->modelData[$key];
        }
        return null;
    }

    /**
     * @return string
     * @see http://www.seanbehan.com/how-to-generate-a-uuid-in-php/
     */
    protected function _generateUuid()
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}