<?php

namespace BlueGoCore\Writers;

use BlueGoCore\Databases\DatabaseFactory;

class WritersFactory {

    protected $databaseFactory;

    public function __construct(DatabaseFactory $databaseFactory){
        $this->databaseFactory = $databaseFactory;
    }

    /**
     * @return \BlueGoCore\Writers\UsersWriter
     */
    public function getUsersWriter(){
        return new \BlueGoCore\Writers\UsersWriter($this->databaseFactory);
    }
}