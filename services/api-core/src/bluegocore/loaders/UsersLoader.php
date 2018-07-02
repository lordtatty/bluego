<?php

namespace BlueGoCore\Loaders;

use BlueGoCore\Models\User;

/**
 * Class UsersLoader
 *
 * There are two main types of methods in this class:
 *   - Loaders will return either an individual, or an array
 *     of UserModels populated with data.
 *   - Iterators will iterate through an array of user data
 *     re-using the same object between each iteration.  This
 *     Saves on performance, but if you intend to use some of
 *     these user objects outside of their iteration cycle
 *     you will need to clone.
 *
 * @package BlueGoCore\Loaders
 */
class UsersLoader{

    /**
     * Iterates through all known users
     *
     * This will re-use the same User object between
     * iterations, so you wll need to clone if you are intending
     * to make use of one or more user object outside of that user's
     * iteration cycle.
     *
     * @return \BlueGoCore\Models\User
     */
    public function iterateAllUsers() {
        $mongodb = new \MongoDB\Client("mongodb://mongodb:27017");
        $db = $mongodb->selectDatabase("test");
        $collection = $db->selectCollection("testcollection");
        $result = $collection->find();

        $userObject = new User();

        foreach($result as $r){
            $userObject->setByBson($r);
            yield $userObject;
        }

    }
}