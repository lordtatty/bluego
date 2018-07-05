<?php

namespace BlueGoCore\Databases;


abstract class DatabaseAbstract {

    protected $dbConfig;
    protected $collection;

    public function __construct(DatabaseConfig $dbConfig, $collection){
        $this->dbConfig = $dbConfig;
        $this->collection = $collection;
    }

} 