<?php

namespace BlueGoCore\Readers;

use BlueGoCore\Storage\StorageFactory;

class ReadersFactory {

    /** @var \BlueGoCore\Storage\StorageFactory */
    protected $storageFactory;

    public function __construct(StorageFactory $factory){
        $this->storageFactory = $factory;
    }

    /**
     * @return \BlueGoCore\Readers\UsersReader
     */
    public function getUsersReader(){
        return new \BlueGoCore\Readers\UsersReader($this->storageFactory);
    }

    /**
     * @return \BlueGoCore\Readers\CoursesReader
     */
    public function getCoursesReader(){
        return new \BlueGoCore\Readers\CoursesReader($this->storageFactory);
    }
}