<?php

namespace BlueGoCore\Storage\Types;

use BlueGoCore\Models\IModel;

class StorageTypeMongo extends StorageTypeAbstract{

    protected $client;
    protected $endpoint;
    protected $databaseName;

    public function __construct($endpoint, $databaseName){
        $this->endpoint = $endpoint;
        $this->databaseName = $databaseName;
    }

    public function getClient() {
        if(!isset($client)) {
            $this->client = new \MongoDB\Client($this->endpoint);
        }
        return $this->client;
    }

    public function save(IModel $model){
        $this->insertData($model->getArray(), $model->getPodName());
    }

    protected function insertData(array $data, $collection){
        $db = $this->getClient()->selectDatabase($this->databaseName);
        $collection = $db->selectCollection($collection);
        $result = $collection->insertOne($data);

        // Ensure this worked before returning a positive response.
        if(!$result->isAcknowledged() || $result->getInsertedCount() !== 1){
            throw new \Exception('Data unexpectedly did not insert to db');
        }
    }

    public function getAllData(IModel $model) {
        $db = $this->getClient()->selectDatabase($this->databaseName);
        $collection = $db->selectCollection($model->getPodName());
        $result = $collection->find();
        $response = [];
        foreach($result as $r){
            /** @var IModel $newModel */
            $newModel = new $model;
            $newModel->setByArray((array)$r);
            $response[] = $newModel;
        }
        return $response;
    }

} 