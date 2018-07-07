<?php

namespace BlueGoCore\Writers;
use BlueGoCore\Databases\DatabaseFactory;
use BlueGoCore\Models\User;

abstract class WriterAbstract {

    /** @var \BlueGoCore\Databases\DatabaseFactory */
    protected $databaseFactory;

    public function __construct(DatabaseFactory $factory){
        $this->databaseFactory = $factory;
    }

    /**
     * @param User $user
     * @throws \Exception
     */
    function saveToDb(User $user)
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
     * @return \BlueGoCore\Databases\Types\DatabaseMongo
     */
    protected function _getDefaultDatabase(){
        return $this->databaseFactory->getDatabase($this->_getPodName());
    }

} 