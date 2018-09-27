<?php

namespace BlueGoCore\Storage\Types;

use BlueGoCore\Models\IModel;
use BlueGoCore\Models\Views\IModelView;
use BlueGoCore\Storage\Mappings\ViewUpdateMapping;

class StorageTypeMongo extends StorageTypeAbstract implements IPersistableStorageType{

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
        $this->updateData($model->getArray(), $model->getPodName());
        $this->updateViews($model);
    }

    protected function getMappingTable(IModel $model){
        $mapping = new ViewUpdateMapping();
        return $this->getDataByUniqueId($model->getPodName() . ':' . $model->getUniqueId(), $mapping);
    }

    protected function updateViews(IModel $model){
        if($model instanceof IModelView){
            foreach($model->iterateAllModels() as $viewAttachedModel){
                $mapping = new ViewUpdateMapping();
                $mapping->addView($model);
                $mapping->setModel($viewAttachedModel);
                $this->updateMapping($mapping);
            }
        }
    }

    protected function updateData(array $data, $collection){
        $db = $this->getClient()->selectDatabase($this->databaseName);
        $collection = $db->selectCollection($collection);
        $result = $collection->updateOne(['uniqueId' => $data['uniqueId']], ['$set' => $data], ['upsert' => true]);



        // Ensure this worked before returning a positive response.
//        if(!$result->isAcknowledged() || $result->getModifiedCount() !== 1){
//            throw new \Exception('Data unexpectedly did not insert to db');
//        }
    }

    protected function updateMapping(ViewUpdateMapping $mapping){
        $collection = $mapping->getPodName();
        $key = $mapping->getUniqueId();
        $data = $mapping->getArray()['views'];
        $db = $this->getClient()->selectDatabase($this->databaseName);
        $collection = $db->selectCollection($collection);
        $collection->updateOne(['uniqueId' => $key], [
                '$set' => ['unqiueId' => $key],
                '$addToSet' => ['views' => ['$each' => array_keys($data)]]
            ],
            ['upsert' => true]);
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

    public function getDataByUniqueId($uniqueId, IModel $model) {
        $db = $this->getClient()->selectDatabase($this->databaseName);
        $collection = $db->selectCollection($model->getPodName());
        $result = $collection->find(['uniqueId' => $uniqueId]);
        foreach($result as $r){
            /** @var IModel $model */
            $model->setByArray((array)$r);
            return $model;
        }
    }

} 