<?php

namespace BlueGoCore\Readers;

use BlueGoCore\Databases\DatabaseFactory;

class ReadersFactory {

    /** @var \BlueGoCore\Databases\DatabaseFactory */
    protected $databaseFactory;

    public function __construct(DatabaseFactory $factory){
        $this->databaseFactory = $factory;
    }

    /**
     * @return \BlueGoCore\Readers\UsersReader
     */
    public function getUsersReader(){
        return new \BlueGoCore\Readers\UsersReader($this->databaseFactory);
    }
}