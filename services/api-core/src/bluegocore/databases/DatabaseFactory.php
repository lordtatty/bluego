<?php

namespace BlueGoCore\Databases;


class DatabaseFactory {

    public function getMongoDatabase()
    {
        return new DatabaseMongo('mongodb://mongodb:27017', 'test', 'testcollection');
    }

}