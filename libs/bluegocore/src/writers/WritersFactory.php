<?php

namespace BlueGoCore\Writers;

use BlueGoCore\Storage\StorageFactory;

class WritersFactory {

    protected $storageFactory;

    public function __construct(StorageFactory $storageFactory){
        $this->storageFactory = $storageFactory;
    }

    /**
     * @return \BlueGoCore\Writers\UsersWriter
     */
    public function getUsersWriter(){
        return new \BlueGoCore\Writers\UsersWriter($this->storageFactory);
    }

    /**
     * @return \BlueGoCore\Writers\UsersWriter
     */
    public function getCoursesWriter(){
        return new \BlueGoCore\Writers\CoursesWriter($this->storageFactory);
    }
}