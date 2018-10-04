<?php

namespace BlueGoCore\Loaders;

use BlueGoCore\Storage\StorageManager;

abstract class ModelConcreteLoaderAbstract {

    private $storageManager;

    public function __construct(StorageManager $storageManager){
        $this->storageManager = $storageManager;
    }

    protected function getStorageManager(){
        return $this->storageManager;
    }

} 