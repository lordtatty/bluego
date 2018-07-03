<?php

namespace BlueGoCore\Loaders;

use BlueGoCore\Models\User;

/**
 * Class UsersLoader
 *
 * @package BlueGoCore\Loaders
 */
class UsersLoader{

    /**
     * Returns an array of all known users
     *
     * @return array[\BlueGoCore\Models\User]
     */
    public function getAllUsers() {
        $mongodb = new \MongoDB\Client("mongodb://mongodb:27017");
        $db = $mongodb->selectDatabase("test");
        $collection = $db->selectCollection("testcollection");
        $result = $collection->find();

        $response = [];
        foreach($result as $r){
            $userObject = new User();
            $userObject->setByBson($r);
            $response[] = $userObject;
        }

        return $response;

    }
}