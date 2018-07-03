<?php

namespace BlueGoCore\Writers;

use BlueGoCore\Models\User;

class UsersWriter extends WriterAbstract{

    /**
     * @param User $user
     * @throws \Exception
     */
    function saveToDb(User $user) {
        $data = $user->getArray();
        $this->getDefaultDatabase()->insertData($data);
    }

} 