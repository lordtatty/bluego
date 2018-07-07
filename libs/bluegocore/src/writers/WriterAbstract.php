<?php

namespace BlueGoCore\Writers;
use BlueGoCore\Storage\StorageFactory;
use BlueGoCore\Models\ModelAbstract;

abstract class WriterAbstract {

    /** @var \BlueGoCore\Storage\StorageFactory */
    protected $storageFactory;

    public function __construct(StorageFactory $factory){
        $this->storageFactory = $factory;
    }

    /**
     * @param ModelAbstract $user
     * @throws \Exception
     */
    function saveToDb(ModelAbstract $user)
    {
        $data = $user->getArray();
        $this->_getDefaultDatabase()->insertData($data);
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
     * Get the default database used by this writer
     *
     * @return \BlueGoCore\Storage\Types\StorageTypeMongo
     */
    protected function _getDefaultDatabase(){
        return $this->storageFactory->getStorage($this->_getPodName());
    }

} 