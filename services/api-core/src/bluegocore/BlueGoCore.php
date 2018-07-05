<?php

namespace BlueGoCore;

use BlueGoCore\Databases\DatabaseFactory;
use BlueGoCore\Loaders\LoadersFactory;
use BlueGoCore\Writers\WritersFactory;

class BlueGoCore {

    protected $databaseFactory;

    public function __construct(DatabaseFactory $databaseFactory){
        $this->databaseFactory = $databaseFactory;
    }

    /**
     * @return \BlueGoCore\Loaders\LoadersFactory
     */
    public function getLoaders() {
        return new LoadersFactory($this->getDatabaseFactory());
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