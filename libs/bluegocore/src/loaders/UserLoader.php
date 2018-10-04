<?php

namespace BlueGoCore\Loaders;

use BlueGoCore\Models\User;

class UserLoader extends ModelConcreteLoaderAbstract {

    /**
     * @return array[User]
     */
    public function getAll(){
        return $this->getStorageManager()->getAllData(new User());
    }

    /**
     * @return User
     */
    public function createNew(){
        $user = new User();
        $this->getStorageManager()->addModel($user);
        return $user;
    }

} 