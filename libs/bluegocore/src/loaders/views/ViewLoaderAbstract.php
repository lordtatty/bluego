<?php

namespace BlueGoCore\Loaders\Views;


use BlueGoCore\Loaders\IModelLoader;
use BlueGoCore\Storage\StorageManager;

abstract class ViewLoaderAbstract Implements IModelLoader{

    private $storageManager;

    public function __construct(StorageManager $storageManager){
        $this->storageManager = $storageManager;
    }

    /**
     * @return StorageManager
     */
    public function getStorageManager(){
        return $this->storageManager;
    }
} 