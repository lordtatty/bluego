<?php

namespace BlueGoCore\Databases;


class DatabaseMongo extends DatabaseAbstract{

    protected $client;

    public function getClient() {
        if(!isset($client)) {
            $this->client = new \MongoDB\Client($this->dbConfig->getEndpoint());
        }
        return $this->client;
    }

    public function insertData(array $data){
        $db = $this->getClient()->selectDatabase($this->dbConfig->getDatabaseName());
        $collection = $db->selectCollection($this->collection);
        $result = $collection->insertOne($data);

        // Ensure this worked before returning a positive response.
        if(!$result->isAcknowledged() || $result->getInsertedCount() !== 1){
            throw new \Exception('Data unexpectedly did not insert to db');
        }
    }

    public function getAllData() {
        $db = $this->getClient()->selectDatabase($this->dbConfig->getDatabaseName());
        $collection = $db->selectCollection($this->collection);
        return $collection->find();
    }

} 