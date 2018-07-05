<?php

namespace BlueGoCore\Databases;


class DatabaseFactory {

    protected $dbName;

    public function __construct($dbName){
        if(!$dbName){
            throw new \Exception("\$dbName must be a string, instead found". var_export($dbName, true));
        }
        $this->dbName = $dbName;
    }

    public function getMongoDatabase()
    {
        return new DatabaseMongo('mongodb://mongodb:27017', $this->dbName, 'testcollection');
    }

}