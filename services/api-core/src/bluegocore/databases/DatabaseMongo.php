<?php

namespace BlueGoCore\Databases;


class DatabaseMongo {

    public function getClient() {
        return new \MongoDB\Client("mongodb://mongodb:27017");
    }

    public function insertData(array $data){
        $mongodb = new \MongoDB\Client("mongodb://mongodb:27017");
        $db = $mongodb->selectDatabase("test");
        $collection = $db->selectCollection("testcollection");
        $result = $collection->insertOne($data);

        // Ensure this worked before returning a positive response.
        if(!$result->isAcknowledged() || $result->getInsertedCount() !== 1){
            throw new \Exception('Data unexpectedly did not insert to db');
        }
    }

    public function getAllData() {
        $mongodb = new \MongoDB\Client("mongodb://mongodb:27017");
        $db = $mongodb->selectDatabase("test");
        $collection = $db->selectCollection("testcollection");
        return $collection->find();
    }

} 