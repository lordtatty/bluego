<?php

namespace BlueGoCore\Writers;

use BlueGoCore\Models\User;

class UsersWriter extends WriterAbstract{

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
     * @param User $user
     * @throws \Exception
     */
    function saveToDb(User $user) {
        $data = $user->getArray();
        $this->_getDefaultDatabase()->insertData($data);
    }


}