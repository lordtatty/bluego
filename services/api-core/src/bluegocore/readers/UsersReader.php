<?php

namespace BlueGoCore\Readers;

use BlueGoCore\Models\User;

/**
 * Class UsersReader
 *
 * @package BlueGoCore\Readers
 */
class UsersReader extends ReaderAbstract{

    /**
     * Get the pod name for this model.
     *
     * In MongoDb this will be the collection name
     * In MySQL this will be the table name
     *
     * @return string the pod name
     */
    protected function _getPodName()
    {
        return 'users';
    }

    /**
     * Returns an array of all known users
     *
     * @return array[\BlueGoCore\Models\User]
     */
    public function getAllUsers() {
        $result = $this->_getDefaultDatabase()->getAllData();

        $response = [];
        foreach($result as $r){
            $userObject = new User();
            $userObject->setByBson($r);
            $response[] = $userObject;
        }

        return $response;

    }
}