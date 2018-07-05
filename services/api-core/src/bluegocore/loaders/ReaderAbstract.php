<?php

namespace BlueGoCore\Loaders;
use BlueGoCore\Databases\DatabaseFactory;

abstract class ReaderAbstract {

    /** @var \BlueGoCore\Databases\DatabaseFactory */
    protected $databaseFactory;

    public function __construct(DatabaseFactory $factory){
        $this->databaseFactory = $factory;
    }

    /**
     * Get the default database used by this loader
     *
     * @return \BlueGoCore\Databases\Types\DatabaseMongo
     */
    protected function getDefaultDatabase(){
        return $this->databaseFactory->getMongoDatabase();
    }

} 