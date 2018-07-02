<?php

namespace BlueGoCore\Writers;

use BlueGoCore\Models\User;

class UsersWriter {

    /**
     * @param User $user
     * @throws \Exception
     */
    function saveToDb(User $user) {
        $data = $user->getArray();

        $mongodb = new \MongoDB\Client("mongodb://mongodb:27017");
        $db = $mongodb->selectDatabase("test");
        $collection = $db->selectCollection("testcollection");
        $result = $collection->insertOne($data);

        // Ensure this worked before returning a positive response.
        if(!$result->isAcknowledged() || $result->getInsertedCount() !== 1){
            throw new \Exception('Data unexpectedly did not insert to db');
        }
    }

} 