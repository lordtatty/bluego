<?php

namespace BlueGoCore\Databases\Types;

use BlueGoCore\Databases\DatabaseConfig;

abstract class DatabaseAbstract {

    protected $dbConfig;
    protected $collection;

    public function __construct(DatabaseConfig $dbConfig, $collection){
        $this->dbConfig = $dbConfig;
        $this->collection = $collection;
    }

} 