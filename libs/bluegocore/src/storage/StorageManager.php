<?php

namespace BlueGoCore\Storage;


use BlueGoCore\Exceptions\StorageConfigException;
use BlueGoCore\Models\IModel;
use BlueGoCore\Models\IModelConcrete;
use BlueGoCore\Models\Views\IModelView;
use BlueGoCore\Storage\Types\IPersistableStorageType;

class StorageManager {

    /** @var array[IPersistableStorageType] $persistedStorage */
    protected $persistedStorage = [];
    protected $models = [];
    protected $views = [];

    public function addPersistedStorage(IPersistableStorageType $storageType){
        $this->persistedStorage[] = $storageType;
    }

    public function addModel(IModelConcrete $model){
        $this->models[] = $model;
        return $this;
    }

    public function addView(IModelView $view){
        $this->views[] = $view;
        return $this;
    }

    public function save(){
        $this->errorIfNoStorageManager();
        foreach($this->models as $model) {
            /** @var IModelConcrete $model*/
            foreach ($this->persistedStorage as $persistedStorage) {
                /** @var IPersistableStorageType $persistedStorage */
                $persistedStorage->save($model);
            }
        }
        foreach($this->views as $view) {
            /** @var IModelView $view*/
            foreach ($this->persistedStorage as $persistedStorage) {
                /** @var IPersistableStorageType $persistedStorage */
                $persistedStorage->save($view);
            }
        }
        $this->models = [];
    }

    public function getAllData(IModel $model){
        $this->errorIfNoStorageManager();
        foreach ($this->persistedStorage as $persistedStorage) {
            /** @var IPersistableStorageType $persistedStorage */
            $result = $persistedStorage->getAllData($model);
            if(!empty($result)){
                return $result;
            }
        }
        return [];
    }

    public function getDataByUniqueId($unqiueId, IModel $model){
        $this->errorIfNoStorageManager();
        foreach ($this->persistedStorage as $persistedStorage) {
            /** @var IPersistableStorageType $persistedStorage */
            $result = $persistedStorage->getDataByUniqueId($unqiueId, $model);
            if(!empty($result)){
                return $result;
            }
        }
        return [];
    }

    protected function errorIfNoStorageManager(){
        if(empty($this->persistedStorage)){
            throw new StorageConfigException('No storage has been added to this storage manager');
        }
    }

} 