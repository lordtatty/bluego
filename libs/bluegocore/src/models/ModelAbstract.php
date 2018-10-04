<?php

namespace BlueGoCore\Models;


use MongoDB\Model\BSONDocument;

abstract class ModelAbstract implements IModel {

    /** @var array $modelData */
    protected $modelData = [];

    /** @var bool $isChanged track if this model has been updated */
    private $isChanged = false;

    /**
     * Reports whether this model has been changed;
     *
     * @return bool
     */
    public function isChanged(){
        return $this->isChanged;
    }

    /**
     * Get an array of the data in this
     * object
     *
     * @return array
     */
    public function getArray()
    {
        $this->_ensureUniqueId();
        $responseArray = $this->getRawArray();
        unset($responseArray['_id']);
        return $responseArray;
    }

    /**
     * @return array
     */
    public function getRawArray(){
        $responseArray = $this->modelData;
        return $responseArray;
    }

    /**
     * Populate this object via an array
     *
     * This should only load data already saved.
     * It does not get marked as being "changed" and
     * therefore will not get persisted to the db
     *
     * @param array $array
     */
    public function loadFromArray(array $array)
    {
        $this->modelData = $array;
        $this->isChanged = false;
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
            $this->modelData['uniqueId'] = $this->getPodName() . ':' .$this->_generateUuid();
        }
    }

    /**
     * Set a property of the model
     *
     * @param $key
     * @param $value
     * @param $type
     * @throws \Exception
     */
    protected function _setModelProperty($key, $value, $type) {

        $exceptionMsg = null;
        switch($type) {
            case 'string':
                if(!is_string($value)){
                    $exceptionMsg = '$name must be a string, instead found: ' . var_export($value, true);
                }
                break;
            case 'int':
                if(!is_int($value)){
                    $exceptionMsg = '$name must be an integer, instead found: ' . var_export($value, true);
                }
                break;
            case 'bool':
                if(!is_bool($value)){
                    $exceptionMsg = '$name must be a boolean, instead found: ' . var_export($value, true);
                }
                break;
            case 'array':
                if(!is_array($value)){
                    $exceptionMsg = '$name must be an array, instead found: ' . var_export($value, true);
                }
                break;
            case 'iModel':
                if(!$value instanceof IModel){
                    $exceptionMsg = '$name must be an instance of IModel, instead found: ' . var_export(get_class($value), true);
                }
                break;
            default:
                throw new \Exception('unknown $type value passed, found:' . var_export($value, true));
        }
        if($exceptionMsg) {
            throw new \InvalidArgumentException($exceptionMsg);
        }

        $this->isChanged = true;
        $this->modelData[$key] = $value;
    }

    protected function _addToModelPropetyArray($modelKey, $valueKey, $value, $type) {
        if(!is_array($this->modelData[$modelKey])){
            $this->modelData[$modelKey] = [];
        }

        $this->modelData[$modelKey][$valueKey] = $value;
        $this->isChanged = true;
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