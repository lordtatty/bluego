<?php

namespace BlueGoCore\Storage;

use BlueGoCore\Storage\Types\StorageTypeMongo;

class StorageFactory {
    /** @var StorageConfig $databaseConfig */
    protected $databaseConfig;

    /**
     * Constructor
     *
     * @param StorageConfig $databaseConfig
     */
    public function __construct(StorageConfig $databaseConfig){
        $this->databaseConfig = $databaseConfig;
    }

    /**
     * Get a database helper object
     *
     * @param string$podName
     * @return StorageTypeMongo
     */
    public function getStorage($podName)
    {
        return new StorageTypeMongo($this->databaseConfig, $podName);
    }

}