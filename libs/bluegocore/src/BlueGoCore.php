<?php

namespace BlueGoCore;

use BlueGoCore\Storage\StorageFactory;
use BlueGoCore\Readers\ReadersFactory;
use BlueGoCore\Writers\WritersFactory;

class BlueGoCore {

    protected $databaseFactory;

    public function __construct(StorageFactory $databaseFactory){
        $this->databaseFactory = $databaseFactory;
    }

    /**
     * @return \BlueGoCore\Readers\ReadersFactory
     */
    public function getReaders() {
        return new ReadersFactory($this->getStorageFactory());
    }

    /**
     * @return \BlueGoCore\Writers\WritersFactory
     */
    public function getWriters() {
        return new WritersFactory($this->getStorageFactory());
    }

    protected function getStorageFactory(){
        return $this->databaseFactory;
    }

}