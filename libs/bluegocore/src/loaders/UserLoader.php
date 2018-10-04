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

} 