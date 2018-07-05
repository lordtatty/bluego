<?php

namespace BlueGoCore\Writers;
use BlueGoCore\Databases\DatabaseFactory;

abstract class WriterAbstract {

    /** @var \BlueGoCore\Databases\DatabaseFactory */
    protected $databaseFactory;

    public function __construct(DatabaseFactory $factory){
        $this->databaseFactory = $factory;
    }

    /**
     * Get the default database used by this writer
     *
     * @return \BlueGoCore\Databases\Types\DatabaseMongo
     */
    protected function getDefaultDatabase(){
        return $this->databaseFactory->getMongoDatabase();
    }

} 