<?php

namespace BlueGoCore\Databases;


class DatabaseFactory {

    public function getMongoDatabase()
    {
        return new DatabaseMongo();
    }

} 