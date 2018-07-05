<?php

namespace BlueGoCore;

use BlueGoCore\Databases\DatabaseFactory;
use BlueGoCore\Readers\ReadersFactory;
use BlueGoCore\Writers\WritersFactory;

class BlueGoCore {

    protected $databaseFactory;

    public function __construct(DatabaseFactory $databaseFactory){
        $this->databaseFactory = $databaseFactory;
    }

    /**
     * @return \BlueGoCore\Readers\ReadersFactory
     */
    public function getReaders() {
        return new ReadersFactory($this->getDatabaseFactory());
    }

    /**
     * @return \BlueGoCore\Writers\WritersFactory
     */
    public function getWriters() {
        return new WritersFactory($this->getDatabaseFactory());
    }

    protected function getDatabaseFactory(){
        return $this->databaseFactory;
    }

}