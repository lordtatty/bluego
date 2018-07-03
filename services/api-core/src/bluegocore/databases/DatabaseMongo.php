<?php

namespace BlueGoCore\Databases;


class DatabaseMongo {

    protected $client;
    protected $endpoint;
    protected $database;
    protected $collection;

    public function __construct($endpoint, $database, $collection){
        $this->endpoint = $endpoint;
        $this->database = $database;
        $this->collection = $collection;
    }

    public function getClient() {
        if(!isset($client)) {
            $this->client = new \MongoDB\Client($this->endpoint);
        }
        return $this->client;
    }

    public function insertData(array $data){
        $db = $this->getClient()->selectDatabase($this->database);
        $collection = $db->selectCollection($this->collection);
        $result = $collection->insertOne($data);

        // Ensure this worked before returning a positive response.
        if(!$result->isAcknowledged() || $result->getInsertedCount() !== 1){
            throw new \Exception('Data unexpectedly did not insert to db');
        }
    }

    public function getAllData() {
        $db = $this->getClient()->selectDatabase($this->database);
        $collection = $db->selectCollection($this->collection);
        return $collection->find();
    }

} 