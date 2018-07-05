<?php

namespace BlueGoCore\Loaders;

use BlueGoCore\Databases\DatabaseFactory;

class ReadersFactory {

    /** @var \BlueGoCore\Databases\DatabaseFactory */
    protected $databaseFactory;

    public function __construct(DatabaseFactory $factory){
        $this->databaseFactory = $factory;
    }

    /**
     * @return \BlueGoCore\Loaders\UsersReader
     */
    public function getUsersReader(){
        return new \BlueGoCore\Loaders\UsersReader($this->databaseFactory);
    }
}