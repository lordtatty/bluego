<?php

namespace BlueGoCore\Databases;

use BlueGoCore\Databases\Types\DatabaseMongo;

class DatabaseFactory {
    /** @var DatabaseConfig $databaseConfig */
    protected $databaseConfig;

    /**
     * Constructor
     *
     * @param DatabaseConfig $databaseConfig
     */
    public function __construct(DatabaseConfig $databaseConfig){
        $this->databaseConfig = $databaseConfig;
    }

    /**
     * Get a mongo database helper object
     * @return DatabaseMongo
     */
    public function getMongoDatabase()
    {
        return new DatabaseMongo($this->databaseConfig, 'testcollection');
    }

}