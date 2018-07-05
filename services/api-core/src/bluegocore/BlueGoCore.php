<?php

namespace BlueGoCore;

use BlueGoCore\Databases\DatabaseFactory;
use BlueGoCore\Loaders\ReadersFactory;
use BlueGoCore\Writers\WritersFactory;

class BlueGoCore {

    protected $databaseFactory;

    public function __construct(DatabaseFactory $databaseFactory){
        $this->databaseFactory = $databaseFactory;
    }

    /**
     * @return \BlueGoCore\Loaders\ReadersFactory
     */
    public function getLoaders() {
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