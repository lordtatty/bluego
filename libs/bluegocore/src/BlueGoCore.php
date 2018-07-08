<?php

namespace BlueGoCore;

use BlueGoCore\Storage\Types\StorageTypeAbstract;

class BlueGoCore {

    protected $storageType;

    public function __construct(StorageTypeAbstract $storageType){
        $this->storageType = $storageType;
    }

    protected function getStorageType(){
        return $this->storageType;
    }

}