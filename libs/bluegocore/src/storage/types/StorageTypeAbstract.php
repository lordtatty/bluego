<?php

namespace BlueGoCore\Storage\Types;

use BlueGoCore\Storage\StorageConfig;

abstract class StorageTypeAbstract {

    protected $dbConfig;
    protected $collection;

    public function __construct(StorageConfig $dbConfig, $collection){
        $this->dbConfig = $dbConfig;
        $this->collection = $collection;
    }

} 