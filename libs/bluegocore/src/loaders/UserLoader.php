<?php

namespace BlueGoCore\Loaders;

use BlueGoCore\Models\User;

class UserLoader extends ModelConcreteLoaderAbstract {

    /**
     * @return array[User]
     */
    public function getAll(){
        return $this->getStorageManager()->getAllData($this->getModel());
    }

    /**
     * @param $id
     * @return \BlueGoCore\Models\User|null
     */
    public function getByUniqueId($id){
        return $this->getStorageManager()->getDataByUniqueId($id, $this->getModel());
    }

    /**
     * @return User
     */
    public function createNew(){
        $user = $this->getModel();
        $this->getStorageManager()->addModel($user);
        return $user;
    }

    /**
     * @return User
     */
    protected function getModel(){
        return new User();
    }

} 