<?php

namespace BlueGoCore\Readers;
use BlueGoCore\Storage\StorageFactory;
use BlueGoCore\Models\ModelAbstract;

abstract class ReaderAbstract {

    /** @var \BlueGoCore\Storage\StorageFactory */
    protected $storageFactory;

    public function __construct(StorageFactory $factory){
        $this->storageFactory = $factory;
    }

    /**
     * Get the pod name for this model.
     *
     * In MongoDb this will be the collection name
     * In MySQL this will be the table name
     *
     * @return string the pod name
     */
    abstract protected function _getPodName();

    /**
     * Get an instance of the model for this writer.
     *
     * @return ModelAbstract the Model
     */
    abstract protected function _getModel();

    /**
     * Get an instance of the model for this writer.
     *
     * @return ModelAbstract the Model
     */
    protected function _getPopulatedModel($data)
    {
        $model = $this->_getModel();
        $model->setByBson($data);
        return $model;
    }

    /**
     * Get the default database used by this writer
     *
     * @return \BlueGoCore\Storage\Types\StorageTypeMongo
     */
    protected function _getDefaultDatabase(){
        return $this->storageFactory->getStorage($this->_getPodName());
    }

} 