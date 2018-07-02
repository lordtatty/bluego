<?php

namespace BlueGoCore\Writers;

use BlueGoCore\Models\User;

class UsersWriter {

    function saveToDb(User $user) {
        $data = $user->getArray();

        $mongodb = new \MongoDB\Client("mongodb://mongodb:27017");
        $db = $mongodb->selectDatabase("test");
        $collection = $db->selectCollection("testcollection");
        $collection->insertOne($data);
        
    }

} 