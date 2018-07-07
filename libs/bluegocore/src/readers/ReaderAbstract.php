<?php

namespace BlueGoCore\Readers;
use BlueGoCore\Databases\DatabaseFactory;
use BlueGoCore\Models\ModelAbstract;

abstract class ReaderAbstract {

    /** @var \BlueGoCore\Databases\DatabaseFactory */
    protected $databaseFactory;

    public function __construct(DatabaseFactory $factory){
        $this->databaseFactory = $factory;
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
     * @return \BlueGoCore\Databases\Types\DatabaseMongo
     */
    protected function _getDefaultDatabase(){
        return $this->databaseFactory->getDatabase($this->_getPodName());
    }

} 