<?php

namespace BlueGoCore\Loaders;

use BlueGoCore\Models\User;

/**
 * Class UsersReader
 *
 * @package BlueGoCore\Loaders
 */
class UsersReader extends ReaderAbstract{

    /**
     * Returns an array of all known users
     *
     * @return array[\BlueGoCore\Models\User]
     */
    public function getAllUsers() {
        $result = $this->getDefaultDatabase()->getAllData();

        $response = [];
        foreach($result as $r){
            $userObject = new User();
            $userObject->setByBson($r);
            $response[] = $userObject;
        }

        return $response;

    }
}