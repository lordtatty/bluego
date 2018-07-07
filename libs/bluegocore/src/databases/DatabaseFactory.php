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
     * Get a database helper object
     *
     * @param string$podName
     * @return DatabaseMongo
     */
    public function getDatabase($podName)
    {
        return new DatabaseMongo($this->databaseConfig, $podName);
    }

}