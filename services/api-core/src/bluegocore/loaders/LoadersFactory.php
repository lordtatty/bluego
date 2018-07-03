<?php

namespace BlueGoCore\Loaders;

use BlueGoCore\Databases\DatabaseFactory;

class LoadersFactory {

    /** @var \BlueGoCore\Databases\DatabaseFactory */
    protected $databaseFactory;

    public function __construct(DatabaseFactory $factory){
        $this->databaseFactory = $factory;
    }

    /**
     * @return \BlueGoCore\Loaders\UsersLoader
     */
    public function getUsersLoader(){
        return new \BlueGoCore\Loaders\UsersLoader($this->databaseFactory);
    }
}